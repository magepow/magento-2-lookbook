<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-06-11 23:15:05
 * @@Modify Date: 2018-06-27 15:43:30
 * @@Function:
 */

namespace Magiccart\Lookbook\Model\Widget\Config;

class Product implements \Magento\Framework\Option\ArrayInterface
{

	protected $scopeConfig;
	protected $_lookbook;

	public function __construct(
		// \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magiccart\Lookbook\Model\Lookbook $lookbook
	)
	{
		$this->_lookbook = $lookbook;
	}

    public function toOptionArray()
    {
		$lookbooks = $this->_lookbook->getCollection()->addFieldToFilter('type_id', '1');
		$options = array();
		foreach ($lookbooks as $item) {
			$options[$item->getIdentifier()] = $item->getTitle();
		}
        return $options;
    }

}
