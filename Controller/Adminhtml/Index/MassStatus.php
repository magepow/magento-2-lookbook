<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-19 13:46:10
 * @@Function:
 */

namespace Magiccart\Lookbook\Controller\Adminhtml\Index;

class MassStatus extends \Magiccart\Lookbook\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $lookbookIds = $this->getRequest()->getParam('lookbook');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');
        if (!is_array($lookbookIds) || empty($lookbookIds)) {
            $this->messageManager->addError(__('Please select Lookbook(s).'));
        } else {
            $collection = $this->_lookbookCollectionFactory->create()
                // ->setStoreViewId($storeViewId)
                ->addFieldToFilter('lookbook_id', ['in' => $lookbookIds]);
            try {
                foreach ($collection as $item) {
                    $item->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been changed status.', count($lookbookIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->_resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
