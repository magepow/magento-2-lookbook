<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2018-06-29 13:13:34
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Widget;

class ProductSlider extends Product
{

	protected $_productSlider;

    protected function _construct()
    {
		$store = $this->_storeManager->getStore()->getStoreId();
        $identifiers = $this->getIdentifiers();
        $collection  = $this->lookbookFactory->create()->getCollection()->addFieldToSelect('*')
                        ->addFieldToFilter('identifier', array('in' => $identifiers))
                        ->addFieldToFilter('type_id', $this->_typeId)
                        ->addFieldToFilter('stores',array( array('finset' => 0), array('finset' => $store)));
        $collection->getSelect()->order('order','ASC');
        if(!$collection){
            echo '<div class="message-error error message">Identifier "'. $identifiers . '" not exist.</div> ';          
            return;
        }
        $this->_productSlider = $collection;
        parent::_construct();
    }

    public function getProductSlider()
    {
        return $this->_productSlider;
    }

    public function getSlider()
    {
        return $this->_productSlider;
    }

}
