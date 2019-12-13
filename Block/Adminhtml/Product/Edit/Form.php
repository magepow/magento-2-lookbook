<?php
/**
 * Magiccart 
 * @lookbook    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-27 16:11:41
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Adminhtml\Product\Edit;

use Magiccart\Lookbook\Model\Status;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @var \Magento\Framework\DataObjectFactory
     */
    protected $_objectFactory;
    /**
     * @var \Magiccart\Lookbook\Model\Lookbook
     */

    protected $_lookbook;

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    protected $_wysiwygConfig;
    protected $_storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\DataObjectFactory $objectFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        \Magiccart\Lookbook\Model\Lookbook $lookbook,
        array $data = []
    ) {
        $this->_objectFactory = $objectFactory;
        $this->_lookbook = $lookbook;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_storeManager  = $context->getStoreManager();
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('lookbook');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            array(
                'data' => array(
                    'id' => 'edit_form',
                    'action' => $this->getUrl('*/*/save', ['store' => $this->getRequest()->getParam('store')]),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ),
            )
        );
        $form->setUseContainer(true);
        $form->setHtmlIdPrefix('magic_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Lookbook Information')]);

        if ($model->getId()) {
            $fieldset->addField('lookbook_id', 'hidden', ['name' => 'lookbook_id']);
        }

        $fieldset->addField('title', 'text',
            [
                'label' => __('Title'),
                'title' => __('Title'),
                'name'  => 'title',
                'required' => true,
            ]
        );

        $identifier = $fieldset->addField('identifier', 'text',
            [
                'label' => __('Identifier'),
                'title' => __('Identifier'),
                'name'  => 'identifier',
                'required' => true,
                'class' => 'validate-xml-identifier',
            ]
        );

        if($this->getRequest()->getParam('lookbook_id')){
            $identifier->setAfterElementHtml(
                '<p class="nm"><small>Don\'t change Identifier</small></p>
                <script type="text/javascript">
                require([
                    "jquery",
                ],  function($){
                        jQuery(document).ready(function($) {
                            var identifier  = "#'.$identifier->getHtmlId().'";                  
                            if ($(identifier).val()) {$(identifier).prop("disabled", true); }
                        })
                })
                </script>
                '
            );
        }

        $fieldset->addField('link', 'text',
            [
                'label' => __('Link'),
                'title' => __('Link'),
                'name'  => 'link',
                'required' => false,
                'after_element_html' => '
                <p class="nm"><small>Link for Lookbook:</small></p>
                <p class="nm"><small>Ex1: http://domain.com/contact</small></p>
                <p class="nm"><small>Ex2: lookbook</small></p>
            ',
            ]
        );

        $image = $fieldset->addField('image', 'image',
            [
                'label' => __('Image'),
                'title' => __('Image'),
                'name'  => 'image',
                'required' => true,
            ]
        );

        // $content = $fieldset->addField('content', 'editor',
        //     [
        //         'label' => __('Content'),
        //         'title' => __('Content'),
        //         'name'  => 'content',
        //         'style' => 'width:600px;height:400px',
        //         'config'    => $this->_wysiwygConfig->getConfig(),
        //         'wysiwyg'   => true,
        //         'required' => false,
        //     ]
        // );

        if($this->getRequest()->getParam('lookbook_id')){
            $editor = $this->getLayout()->createBlock(
                'Magiccart\Lookbook\Block\Adminhtml\Helper\Edit\Editor'
            )->setTemplate('helper/product.phtml');

            $editor->setData('lookbook', $model);
            $image->setAfterElementHtml(
                $editor->toHtml()
            );
        }

        /* Check is single store mode */
        if (!$this->_storeManager->isSingleStoreMode()) {
            $field = $fieldset->addField(
                'stores',
                'multiselect',
                [
                    'name' => 'stores[]',
                    'label' => __('Store View'),
                    'title' => __('Store View'),
                    'required' => true,
                    'values' => $this->_systemStore->getStoreValuesForForm(false, true)
                ]
            );
            $renderer = $this->getLayout()->createBlock(
                'Magento\Backend\Block\Store\Switcher\Form\Renderer\Fieldset\Element'
            );
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField(
                'stores',
                'hidden',
                ['name' => 'stores[]', 'value' => $this->_storeManager->getStore(true)->getId()]
            );
            $model->setStoreId($this->_storeManager->getStore(true)->getId());
        }

        $fieldset->addField('order', 'text',
            [
                'label' => __('Order'),
                'title' => __('Order'),
                'name'  => 'order',
                'required' => false,
            ]
        );

        $fieldset->addField('status', 'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $form->addValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
