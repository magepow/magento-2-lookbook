<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2018-05-16 10:40:51
 * @@Modify Date: 2018-06-27 15:18:53
 * @@Function:
 */

namespace Magiccart\Lookbook\Controller\Adminhtml\Product;

class MassDelete extends \Magiccart\Lookbook\Controller\Adminhtml\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $lookbookIds = $this->getRequest()->getParam('lookbook');
        if (!is_array($lookbookIds) || empty($lookbookIds)) {
            $this->messageManager->addError(__('Please select lookbook(s).'));
        } else {
            $collection = $this->_lookbookCollectionFactory->create()
                ->addFieldToFilter('lookbook_id', ['in' => $lookbookIds]);
            try {
                foreach ($collection as $item) {
                    $item->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 record(s) have been deleted.', count($lookbookIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $resultRedirect = $this->_resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
