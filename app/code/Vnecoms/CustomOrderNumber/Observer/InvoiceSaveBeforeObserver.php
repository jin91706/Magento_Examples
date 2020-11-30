<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Observer;

class InvoiceSaveBeforeObserver extends AbstractObserver
{
    /**
     * Customize order increment id.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->_helper->isModuleEnable()) {
            return;
        }
        $invoice = $observer->getInvoice();
        if ($invoice->getIncrementId()) {
            return;
        }

        $order = $invoice->getOrder();

        $entityType = $invoice->getEntityType();
        $orderStoreId = $order->getStoreId();

        if ($this->_helper->useSameIncrementNumberAsOrder($entityType, $orderStoreId)) {
            $incrementId = $this->copyIncrementIdFromOrder($invoice);
        } else {
            $incrementId = $this->getIncrementId($invoice);
        }

        $invoice->setIncrementId($incrementId);
    }
}
