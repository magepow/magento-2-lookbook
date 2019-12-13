<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 15:15:05
 * @@Modify Date: 2018-05-16 15:52:06
 * @@Function:
 */

namespace Magiccart\Lookbook\Model\ResourceModel\Lookbook;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_init('Magiccart\Lookbook\Model\Lookbook', 'Magiccart\Lookbook\Model\ResourceModel\Lookbook');
    }
}
