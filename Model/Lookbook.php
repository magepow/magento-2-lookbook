<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 23:15:05
 * @@Modify Date: 2018-05-16 23:50:55
 * @@Function:
 */

namespace Magiccart\Lookbook\Model;

class Lookbook extends \Magento\Framework\Model\AbstractModel
{

    protected $_lookbookCollectionFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magiccart\Lookbook\Model\ResourceModel\Lookbook\CollectionFactory $lookbookCollectionFactory,
        \Magiccart\Lookbook\Model\ResourceModel\Lookbook $resource,
        \Magiccart\Lookbook\Model\ResourceModel\Lookbook\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_lookbookCollectionFactory = $lookbookCollectionFactory;
    }

}
