<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-19 13:44:55
 * @@Function:
 */

namespace Magiccart\Lookbook\Controller\Adminhtml\Index;

use Magento\Framework\App\Filesystem\DirectoryList;

class ExportCsv extends \Magiccart\Lookbook\Controller\Adminhtml\Action
{
    public function execute()
    {
        $fileName = 'lookbook.csv';

        /** @var \\Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $content = $resultPage->getLayout()->createBlock('Magiccart\Lookbook\Block\Adminhtml\Lookbook\Grid')->getCsv();

        return $this->_fileFactory->create($fileName, $content, DirectoryList::VAR_DIR);
    }
}
