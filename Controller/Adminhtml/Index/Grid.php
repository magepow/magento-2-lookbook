<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2016-04-22 17:03:07
 * @@Function:
 */

namespace Magiccart\Lookbook\Controller\Adminhtml\Index;

class Grid extends \Magiccart\Lookbook\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        return $resultLayout;
    }
}
