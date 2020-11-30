<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Observer;

class ShipmentSaveBeforeObserver extends AbstractObserver
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
        $shipment = $observer->getShipment();
        if ($shipment->getIncrementId()) {
            return;
        }

        $order = $shipment->getOrder();

        $entityType = $shipment->getEntityType();
        $orderStoreId = $order->getStoreId();

        if ($this->_helper->useSameIncrementNumberAsOrder($entityType, $orderStoreId)) {
            $incrementId = $this->copyIncrementIdFromOrder($shipment);
        } else {
            $incrementId = $this->getIncrementId($shipment);
        }

        $shipment->setIncrementId($incrementId);
    }
}
