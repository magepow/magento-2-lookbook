<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-27 16:22:56
 * @@Modify Date: 2018-06-27 16:28:44
 * @@Function:
 */
namespace Magiccart\Lookbook\Block\Adminhtml\Helper\Grid;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Lookbook factory.
     *
     * @var \Magiccart\Lookbook\Model\LookbookFactory
     */
    protected $_lookbookFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Backend\Block\Context              $context
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param array                                       $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magiccart\Lookbook\Model\LookbookFactory $lookbookFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_lookbookFactory  = $lookbookFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $item = $this->_lookbookFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
        $_images = $item->getImage();
        $src     = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $_images;

        return '<image style="max-width:100px;" src ="'.$src.'" alt="Preview" >';
    }
}
