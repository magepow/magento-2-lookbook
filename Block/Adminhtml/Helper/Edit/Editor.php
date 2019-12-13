<?php
/**
 * Magiccart 
 * @lookbook    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-27 15:56:16
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Adminhtml\Helper\Edit;

class Editor extends \Magento\Framework\View\Element\Template // \Magento\Framework\View\Element\AbstractBlock
{

    /**
     * @var string
     */
    // protected $_template = 'editor.phtml';

    protected $_storeManager;

    protected $_imageFactory;

    public $assetRepository;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        array $data = []
    ) {
        $this->_storeManager  = $context->getStoreManager();
        $this->assetRepository = $context->getAssetRepository();
        $this->_imageFactory = $imageFactory;
        parent::__construct($context, $data);
    }

    public function getImageUrl($file)
    {
       $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $file;
        return $resizedURL;
    }

    public function getImageInfo($file)
    {
        $absolutePath = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath($file);
        $image = $this->_imageFactory->create();         
        $image->open($absolutePath);
        return $image;
    }

}
