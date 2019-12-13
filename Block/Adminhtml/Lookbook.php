<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-18 14:02:16
 * @@Function:
 */

namespace Magiccart\Lookbook\Block\Adminhtml;

class Lookbook extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor.
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_lookbook';
        $this->_blockGroup = 'Magiccart_Lookbook';
        $this->_headerText = __('Lookbook');
        $this->_addButtonLabel = __('Add New Lookbook');
        parent::_construct();
    }
}
