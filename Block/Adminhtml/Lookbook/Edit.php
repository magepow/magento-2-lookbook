<?php
/**
 * Magiccart 
 * @lookbook    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-18 14:03:00
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Adminhtml\Lookbook;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
 
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    
    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'lookbook_id';
        $this->_blockGroup = 'Magiccart_Lookbook';
        $this->_controller = 'adminhtml_lookbook';

        parent::_construct();

        $this->buttonList->update('delete', 'label', __('Delete'));
        $this->buttonList->remove('delete');

        $this->buttonList->update('save', 'label', __('Save Lookbook'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );
 
        // if ($this->_coreRegistry->registry('lookbook')->getId()) {
            $this->buttonList->remove('reset');
        // }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Retrieve the save and continue edit Url.
     *
     * @return string
     */
    protected function getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'tab' => '{{tab_id}}',
                'store' => $this->getRequest()->getParam('store'),
                'lookbook_id' => $this->getRequest()->getParam('lookbook_id'),
                'current_lookbook_id' => $this->getRequest()->getParam('current_lookbook_id'),
            ]
        );
    }

    /**
     * Retrieve the save and continue edit Url.
     *
     * @return string
     */
    protected function getSaveAndCloseWindowUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'tab' => '{{tab_id}}',
                'store' => $this->getRequest()->getParam('store'),
                'lookbook_id' => $this->getRequest()->getParam('lookbook_id'),
                'current_lookbook_id' => $this->getRequest()->getParam('current_lookbook_id'),
                'saveandclose' => 1,
            ]
        );
    }
}
