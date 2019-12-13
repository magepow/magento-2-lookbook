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
    const SECTIONS      = 'lookbook';   // module name
    const GROUPS        = 'general';    // setup general

    public function getConfig($cfg=null)
    {
        if($cfg) return $this->scopeConfig->getValue( $cfg, \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
        return $this->scopeConfig;
    }

    public function getGeneralCfg($cfg=null) 
    {
        $config = $this->scopeConfig->getValue(
            self::SECTIONS.'/'.self::GROUPS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if(isset($config[$cfg])) return $config[$cfg];
        return $config;
    }
}
