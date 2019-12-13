<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 15:15:05
 * @@Modify Date: 2018-05-16 15:51:38
 * @@Function:
 */

namespace Magiccart\Lookbook\Model\ResourceModel;

class Lookbook extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('magiccart_lookbook', 'lookbook_id');
    }
}
