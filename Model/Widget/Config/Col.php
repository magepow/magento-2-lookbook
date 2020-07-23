<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-02-10 22:10:30
 * @@Modify Date: 2017-03-21 11:13:37
 * @@Function:
 */
namespace Magiccart\Lookbook\Model\Widget\Config;

class Col implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1,   'label'=>__('1 item(s) /row')),
            array('value' => 2,   'label'=>__('2 item(s) /row')),
            array('value' => 3,   'label'=>__('3 item(s) /row')),
            array('value' => 4,   'label'=>__('4 item(s) /row')),
            array('value' => 5,   'label'=>__('5 item(s) /row')),
            array('value' => 6,   'label'=>__('6 item(s) /row')),
            array('value' => 7,   'label'=>__('7 item(s) /row')),
            array('value' => 8,   'label'=>__('8 item(s) /row')),
        );
    }
}
