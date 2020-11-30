<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Data extends AbstractHelper
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Is Module Enable.
     * 
     * @return string
     */
    public function isModuleEnable()
    {
        return $this->scopeConfig->getValue(
            'customordernumber/general/enabled'
        );
    }

    /**
     * Get Order Prefix.
     * 
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function getPrefix($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/prefix',
            'store',
            $storeId
        );
    }

    /**
     * Get Order Suffix.
     * 
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function getSuffix($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/suffix',
            'store',
            $storeId
        );
    }

    /**
     * Get Number Length.
     *
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function getNumberLength($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/number_length',
            'store',
            $storeId
        );
    }

    /**
     * Get Increment Step.
     *
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function getStep($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/step',
            'store',
            $storeId
        );
    }

    /**
     * Get Increment Step.
     *
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function getStartValue($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/start_value',
            'store',
            $storeId
        );
    }

    /**
     * Get Increment Step.
     *
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function isSeparatedCounterForWebsite($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/website_counter',
            'store',
            $storeId
        );
    }

    /**
     * Get Increment Step.
     *
     * @param string $entityType
     * @param int    $storeId
     *
     * @return string
     */
    public function isSeparatedCounterForStore($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/store_counter',
            'store',
            $storeId
        );
    }

    /**
     * Is used same increment number as order.
     * 
     * @param string $entityType
     * @param int    $storeId
     *
     * @return bool
     */
    public function useSameIncrementNumberAsOrder($entityType, $storeId)
    {
        return $this->scopeConfig->getValue(
            'customordernumber/'.$entityType.'/same_as_order',
            'store',
            $storeId
        );
    }
}
