<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2018-06-27 17:23:15
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Widget;

class Lookbook extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{

    protected $_storeManager;

	protected $_lookbook;

    protected $_typeId = '2';
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magiccart\Lookbook\Model\Lookbook $lookbook,
        array $data = []
    ) {
        $this->_lookbook = $lookbook;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
		$store = $this->_storeManager->getStore()->getStoreId();
        $identifier = $this->getIdentifier();
        $collection = $this->_lookbook->getCollection()->addFieldToSelect('*')
                        ->addFieldToFilter('identifier', $identifier)
                        ->addFieldToFilter('type_id', $this->_typeId)
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)))
                        ->setPageSize(1);
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

    public function getPinImageUrl($file)
    {
       $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $file;
        return $resizedURL;
    }
    
}
