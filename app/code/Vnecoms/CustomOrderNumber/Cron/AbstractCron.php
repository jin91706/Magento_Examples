<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Cron;

use Magento\Framework\App\ResourceConnection as AppResource;

class AbstractCron
{
    /**
     * @var false|\Magento\Framework\DB\Adapter\AdapterInterface
     */
    private $connection;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Constructor.
     * 
     * @param AppResource $resource
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        AppResource $resource
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->connection = $resource->getConnection('sales');
    }

    /**
     * Get sequence table.
     * 
     * @return string
     */
    public function getSequenceTable()
    {
        return $this->connection->getTableName('ves_custom_order_num');
    }

    /**
     * Can reset counter.
     * 
     * @param string $entityType
     *
     * @return \Magento\Framework\App\Config\mixed
     */
    public function canReset($entityType)
    {
        return $this->_scopeConfig->getValue(
            'customordernumber/'.$entityType.'/auto_reset_counter'
        );
    }

    /**
     * Reset Counter.
     * 
     * @param string $entityType
     *
     * @return \Magento\ProductAlert\Model\AbstractCron
     */
    public function resetCounter($entityType)
    {
        if ($this->canReset($entityType)) {
            $this->connection->delete(
                $this->getSequenceTable(),
                'entity_type = "'.$entityType.'"'
            );
        }

        return $this;
    }
}
