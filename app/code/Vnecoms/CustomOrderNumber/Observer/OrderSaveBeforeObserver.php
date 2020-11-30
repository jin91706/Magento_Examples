<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vnecoms\CustomOrderNumber\Model\Manager;
use Vnecoms\CustomOrderNumber\Helper\Data as Helper;

class OrderSaveBeforeObserver implements ObserverInterface
{
    /**
     * @var Manager
     */
    protected $_sequenceManager;

    /**
     * @var \Vnecoms\CustomOrderNumber\Helper\Data
     */
    protected $_helper;

    /**
     * Constructor.
     * 
     * @param Manager $sequenceManager
     */
    public function __construct(
        Manager $sequenceManager,
        Helper $helper
    ) {
        $this->_helper = $helper;
        $this->_sequenceManager = $sequenceManager;
    }
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
        $order = $observer->getOrder();

        $entityType = $order->getEntityType();
        $orderStoreId = $order->getStoreId();

        if ($this->_helper->isSeparatedCounterForStore($entityType, $orderStoreId)) {
            $storeId = $order->getStoreId();
        } elseif (
            $this->_helper->isSeparatedCounterForWebsite(
                $entityType,
                $orderStoreId
            )
        ) {
            /*Use counter of default store of the website.*/
            $storeId = $order->getStore()->getWebsite()->getDefaultStore()->getId();
        } else {
            $storeId = 0;
        }

        $order->setIncrementId(
            $this->_sequenceManager->getSequence(
                $entityType,
                $storeId,
                $orderStoreId
            )->getNextValue()
        );
    }
}
