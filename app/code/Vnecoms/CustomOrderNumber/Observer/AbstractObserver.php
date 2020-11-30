<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Observer;

use Magento\Framework\Event\ObserverInterface;
use Vnecoms\CustomOrderNumber\Model\Manager;
use Vnecoms\CustomOrderNumber\Helper\Data as Helper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class AbstractObserver implements ObserverInterface
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
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;

    /**
     * Constructor.
     * 
     * @param Manager $sequenceManager
     */
    public function __construct(
        Manager $sequenceManager,
        TimezoneInterface $localeDate,
        Helper $helper
    ) {
        $this->_helper = $helper;
        $this->_sequenceManager = $sequenceManager;
        $this->_localeDate = $localeDate;
    }

    /**
     * (non-PHPdoc).
     *
     * @see \Magento\Framework\Event\ObserverInterface::execute()
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        return $this;
    }

    /**
     * Process Variables.
     *
     * @param unknown $text
     *
     * @return string
     */
    public function processVariables($text, $date, $orderDate = null)
    {
        $dateTime = $this->_localeDate->date($date);

        $text = str_replace('{yyyy}', $dateTime->format('Y'), $text);
        $text = str_replace('{yy}', $dateTime->format('y'), $text);
        $text = str_replace('{mm}', $dateTime->format('m'), $text);
        $text = str_replace('{m}', $dateTime->format('n'), $text);
        $text = str_replace('{dd}', $dateTime->format('d'), $text);
        $text = str_replace('{d}', $dateTime->format('j'), $text);

        if ($orderDate) {
            $orderDateTime = $this->_localeDate->date($orderDate);
            $text = str_replace('{order_date.yyyy}', $orderDateTime->format('Y'), $text);
            $text = str_replace('{order_date.yy}', $orderDateTime->format('y'), $text);
            $text = str_replace('{order_date.mm}', $orderDateTime->format('m'), $text);
            $text = str_replace('{order_date.m}', $orderDateTime->format('n'), $text);
            $text = str_replace('{order_date.dd}', $orderDateTime->format('d'), $text);
            $text = str_replace('{order_date.d}', $orderDateTime->format('j'), $text);
        }

        return $text;
    }

    /**
     * Get the invoice id uses the increment number from order.
     * 
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     *
     * @return mixed
     */
    public function copyIncrementIdFromOrder(
        \Magento\Sales\Model\AbstractModel $model
    ) {
        $order = $model->getOrder();

        $incrementId = $order->getIncrementId();
        $entityType = $model->getEntityType();

        $orderPrefix = $this->_helper->getPrefix('order', $order->getStoreId());
        $orderPrefix = $this->processVariables($orderPrefix, $order->getCreatedAt());

        $orderSuffix = $this->_helper->getSuffix('order', $order->getStoreId());
        $orderSuffix = $this->processVariables($orderSuffix, $order->getCreatedAt());

        $invoicePrefix = $this->_helper->getPrefix($entityType, $order->getStoreId());
        $invoicePrefix = $this->processVariables($invoicePrefix, $model->getCreatedAt(), $order->getCreatedAt());

        $invoiceSuffix = $this->_helper->getSuffix($entityType, $order->getStoreId());
        $invoiceSuffix = $this->processVariables($invoiceSuffix, $model->getCreatedAt(), $order->getCreatedAt());

        if (strpos($incrementId, $orderPrefix) !== false) {
            $incrementId = str_replace($orderPrefix, $invoicePrefix, $incrementId);
        } else {
            $incrementId = $invoicePrefix.$incrementId;
        }

        if (strpos($incrementId, $orderPrefix) !== false) {
            $incrementId = str_replace($orderSuffix, $invoiceSuffix, $incrementId);
        } else {
            $incrementId .= $invoiceSuffix;
        }

        return $incrementId;
    }

    /**
     * Get Invoice increment id.
     * 
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     *
     * @return string
     */
    public function getIncrementId(
        \Magento\Sales\Model\AbstractModel $model
    ) {
        $order = $model->getOrder();

        $entityType = $model->getEntityType();
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

        $incrementId = $this->_sequenceManager->getSequence(
            $entityType,
            $storeId,
            $orderStoreId
        )->getNextValue();

        return $incrementId;
    }
}
