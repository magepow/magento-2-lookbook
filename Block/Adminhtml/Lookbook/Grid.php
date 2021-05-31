<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2019-01-25 16:29:38
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Adminhtml\Lookbook;

use Magiccart\Lookbook\Model\Status;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * lookbook collection factory.
     *
     * @var \Magiccart\Lookbook\Model\ResourceModel\Lookbook\CollectionFactory
     */
    protected $_lookbookCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * construct.
     *
     * @param \Magento\Backend\Block\Template\Context                         $context
     * @param \Magento\Backend\Helper\Data                                    $backendHelper
     * @param \Magento\Catalog\Model\CategoryFactory                          $categoryFactory
     * @param \Magiccart\Lookbook\Model\ResourceModel\Lookbook\CollectionFactory $lookbookCollectionFactory
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magiccart\Lookbook\Model\ResourceModel\Lookbook\CollectionFactory $lookbookCollectionFactory,
    
        array $data = []
    ) {
        $this->_lookbookCollectionFactory = $lookbookCollectionFactory;
        $this->_categoryFactory = $categoryFactory;

        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('lookbookGrid');
        $this->setDefaultSort('lookbook_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {

        $store = $this->getRequest()->getParam('store');
        $collection = $this->_lookbookCollectionFactory->create();
        if($store) $collection->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)));
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'type' => 'text',
                'index' => 'title',
                'header_css_class' => 'col-title',
                'column_css_class' => 'col-title',
            ]
        );

        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'type' => 'text',
                'index' => 'identifier',
                'header_css_class' => 'col-identifier',
                'column_css_class' => 'col-identifier',
            ]
        );

        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'class' => 'xxx',
                'width' => '50px',
                'filter' => false,
                'renderer' => 'Magiccart\Lookbook\Block\Adminhtml\Helper\Grid\Image',
            ]
        );

        // if (!$this->_storeManager->isSingleStoreMode()) {
        //     $this->addColumn(
        //         'stores',
        //         [
        //             'header' => __('Store View'),
        //             'index' => 'stores',
        //             'type' => 'store',
        //             'store_all' => true,
        //             'store_view' => true,
        //             'sortable' => false,
        //             'filter_condition_callback' => [$this, '_filterStoreCondition']
        //         ]
        //     );
        // }

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'lookbook_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        $this->addExportType('*/*/exportCsv', __('CSV'));
        $this->addExportType('*/*/exportXml', __('XML'));
        $this->addExportType('*/*/exportExcel', __('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * get slider vailable option
     *
     * @return array
     */

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('lookbook_id');
        $this->getMassactionBlock()->setFormFieldName('lookbook');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('lookbook/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = Status::getAvailableStatuses();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('lookbook/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * get row url
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['lookbook_id' => $row->getId()]
        );
    }
}
