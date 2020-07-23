<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2020-07-23 13:13:34
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Widget;

use Magiccart\Lookbook\Model\Design\Frontend\Responsive;

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

        if($this->getData('slide')){
            $data['vertical-Swiping'] = $this->getData('vertical');
            $breakpoints = $this->getResponsiveBreakpoints();
            $responsive = '[';
            $num = count($breakpoints);
            foreach ($breakpoints as $size => $opt) {
                $item = (int)  $this->getData($opt);
                $responsive .= '{"breakpoint": "'.$size.'", "settings": {"slidesToShow": "'.$item.'"}}';
                $num--;
                if($num) $responsive .= ', ';
            }
            $responsive .= ']';
            $data['slides-To-Show'] = $this->getData('visible');
            $data['swipe-To-Slide'] = 'true';
            $data['responsive'] = $responsive;
            
            $this->addData($data);
        }

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

    public function getResponsiveBreakpoints()
    {
        return Responsive::getBreakpoints();
    }

    public function getSlideOptions()
    {
        return array('autoplay', 'arrows', 'autoplay-Speed', 'dots', 'infinite', 'padding', 'vertical', 'vertical-Swiping', 'responsive', 'rows', 'slides-To-Show', 'swipe-To-Slide');
    }

    public function getFrontendCfg()
    { 
        if($this->getSlide()) return $this->getSlideOptions();

        $this->addData(array('responsive' =>json_encode($this->getGridOptions())));
        return array('padding', 'responsive');

    }

    public function getGridOptions()
    {
        $options = array();
        $breakpoints = $this->getResponsiveBreakpoints(); ksort($breakpoints);
        foreach ($breakpoints as $size => $screen) {
            $item = (int) $this->getData($screen);
            if(!$item) continue;
            $options[]= array($size-1 => $this->getData($screen));
        }
        return $options;
    }

}
