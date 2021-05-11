<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 20:26:27
 * @@Modify Date: 2018-05-16 23:15:41
 * @@Function:
 */

namespace Magiccart\Lookbook\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var array
     */
    protected $configModule;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\Manager $moduleManager
    )
    {
        parent::__construct($context);
        $this->moduleManager = $moduleManager;
        $module = strtolower(str_replace('Magiccart_', '', $this->_getModuleName()));
        $this->configModule = $this->getConfig($module);

    }

    public function getConfig($cfg='')
    {
        if($cfg) return $this->scopeConfig->getValue( $cfg, \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
        return $this->scopeConfig;
    }

    public function getConfigModule($cfg='', $value=null)
    {
        $values = $this->configModule;
        if( !$cfg ) return $values;
        $config  = explode('/', $cfg);
        $end     = count($config) - 1;
        foreach ($config as $key => $vl) {
            if( isset($values[$vl]) ){
                if( $key == $end ) {
                    $value = $values[$vl];
                }else {
                    $values = $values[$vl];
                }
            } 

        }
        return $value;
    }

    public function isEnabledModule($moduleName)
    {
        return $this->moduleManager->isEnabled($moduleName);
    }

}