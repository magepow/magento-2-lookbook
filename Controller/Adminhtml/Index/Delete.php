<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2016-04-22 17:05:05
 * @@Function:
 */

namespace Magiccart\Lookbook\Controller\Adminhtml\Index;

class Delete extends \Magiccart\Lookbook\Controller\Adminhtml\Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('lookbook_id');
        try {
            $item = $this->_lookbookFactory->create()->setId($id);
            $item->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->_resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
