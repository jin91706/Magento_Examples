<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Observer;

class CreditmemoSaveBeforeObserver extends AbstractObserver
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
        $creditmemo = $observer->getCreditmemo();
        if ($creditmemo->getIncrementId()) {
            return;
        }

        $order = $creditmemo->getOrder();

        $entityType = $creditmemo->getEntityType();
        $orderStoreId = $order->getStoreId();

        if ($this->_helper->useSameIncrementNumberAsOrder($entityType, $orderStoreId)) {
            $incrementId = $this->copyIncrementIdFromOrder($creditmemo);
        } else {
            $incrementId = $this->getIncrementId($creditmemo);
        }

        $creditmemo->setIncrementId($incrementId);
    }
}
