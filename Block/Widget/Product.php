<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2018-06-27 17:20:42
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Widget;

class Product extends \Magento\Catalog\Block\Product\AbstractProduct implements \Magento\Widget\Block\BlockInterface
{

    /**
     * @var \Magento\Framework\Url\Helper\Data
     */
    protected $urlHelper;

    protected $_storeManager;

    protected $_productCollectionFactory;

	protected $_lookbook;

    protected $_typeId = '1';

    /**
     * @param Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magiccart\Lookbook\Model\Lookbook $lookbook,
        array $data = []
    ) {
        $this->urlHelper = $urlHelper;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_lookbook = $lookbook;
        parent::__construct( $context, $data );
    }

    protected function _construct()
    {
		$store = $this->_storeManager->getStore()->getStoreId();
        $identifier = $this->getIdentifier();
        $collection = $this->_lookbook->getCollection()->addFieldToSelect('*')
                        ->addFieldToFilter('identifier', $identifier)
                        ->addFieldToFilter('type_id', $this->_typeId)
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)));
        $collection->getSelect()->order('order','ASC');

        $item = $collection->getFirstItem();
        if(!$item){
            echo '<div class="message-error error message">Identifier "'. $identifier . '" not exist.</div> ';          
            return;
        }
        $data = $item->getData();
        $this->addData($data);
        parent::_construct();
    }

    public function getProductCollection($producIds)
    {
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*')
                ->addAttributeToFilter('entity_id', array('in' => $producIds));
        return $productCollection;
     
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
