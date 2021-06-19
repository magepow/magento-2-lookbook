<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2020-07-23 17:20:42
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Widget;

use Magento\Framework\App\Filesystem\DirectoryList;

class Product extends \Magento\Catalog\Block\Product\AbstractProduct implements \Magento\Widget\Block\BlockInterface
{

    const MEDIA_PATH = 'magiccart/lookbook';

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    protected $urlHelper;

    /**
     * @var \Magento\Framework\Image\AdapterFactory
     */
    protected $_imageFactory;

     /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $backendUrl;

    protected $_filesystem;

    protected $_directory;

    protected $_productCollectionFactory;

    protected $_lookbook;

    protected $_typeId = '1';

    /**
     * @var \Magiccart\Lookbook\Model\LookbookFactory
     */
    protected $lookbookFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Url\Helper\Data $urlHelper
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magiccart\Lookbook\Model\LookbookFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Image\AdapterFactory $imageFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magiccart\Lookbook\Model\LookbookFactory $lookbookFactory,
        array $data = []
    ) {
        $this->urlHelper     = $urlHelper;
        $this->_imageFactory = $imageFactory;
        $this->backendUrl    = $backendUrl;
        $this->_filesystem   = $context->getFilesystem();
        $this->_directory    = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA);

        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->lookbookFactory = $lookbookFactory;
        parent::__construct( $context, $data );
    }

    protected function _construct()
    {
        $lookbook = $this->getLookbook();
        if(!$lookbook){
            echo '<div class="message-error error message">Identifier "'. $this->getIdentifier() . '" not exist.</div> ';          
            return;
        }
        $data = $lookbook->getData();
        $this->addData($data);
        parent::_construct();
    }

    public function getLookbook()
    {
        if($this->getData('lookbook')) $this->_lookbook = $this->getData('lookbook');
        if($this->_lookbook) return $this->_lookbook;
        $store = $this->_storeManager->getStore()->getStoreId();
        $identifier = $this->getIdentifier();
        $collection = $this->lookbookFactory->create()->getCollection()->addFieldToSelect('*')
                        ->addFieldToFilter('identifier', $identifier)
                        ->addFieldToFilter('type_id', $this->_typeId)
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->setPageSize(1);
        $collection->getSelect()->order('order','ASC');

        $this->_lookbook = $collection->getFirstItem();
        return  $this->_lookbook;
    }

    public function getAdminUrl($adminPath, $routeParams=[], $storeCode = 'default' ) 
    {
        $routeParams[] = [ '_nosid' => true, '_query' => ['___store' => $storeCode]];
        return $this->backendUrl->getUrl($adminPath, $routeParams);
    }

    public function getQuickedit()
    {
        return;      
    }

    public function getProductCollection($producIds)
    {
        $productCollection = $this->_productCollectionFactory->create()
                                ->addAttributeToSelect('*')
                                ->addAttributeToFilter('entity_id', array('in' => $producIds))
                                ->addStoreFilter()
                                ->addMinimalPrice()
                                ->addFinalPrice()
                                ->addTaxPercents();

        return $productCollection;
     }

    public function getLookImage()
    {
        $file = $this->getData('image');
        if(!$file) return;
        $absPath = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . $file;
        if( !file_exists($absPath) ) return;
        $_image = $this->_imageFactory->create();
        $_image->open($absPath);
        $image = new \Magento\Framework\DataObject();
        if($_image){
            $width  = $_image->getOriginalWidth();
            $height = $_image->getOriginalHeight();
            $url    = $this->getPinImageUrl($file);
            $image->setData('width', $width);
            $image->setData('height', $height);
            $image->setData('url', $url);
        }

        return $image;
    }

    public function getPinImageUrl($file)
    {
       $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $file;
        return $resizedURL;
    }
    
    /**
     * Get post parameters
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     */
    public function getAddToCartPostParams(\Magento\Catalog\Model\Product $product)
    {
        $url = $this->getAddToCartUrl($product);
        return [
            'action' => $url,
            'data' => [
                'product' => $product->getEntityId(),
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED =>
                    $this->urlHelper->getEncodedUrl($url),
            ]
        ];
    }

}
