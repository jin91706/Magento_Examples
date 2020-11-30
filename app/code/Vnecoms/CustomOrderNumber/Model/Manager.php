<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Model;

use Magento\SalesSequence\Model\ResourceModel\Meta as ResourceSequenceMeta;

/**
 * Class Manager.
 */
class Manager
{
    /**
     * @var SequenceFactory
     */
    protected $sequenceFactory;

    /**
     * @param ResourceSequenceMeta $resourceSequenceMeta
     * @param SequenceFactory      $sequenceFactory
     */
    public function __construct(
        SequenceFactory $sequenceFactory
    ) {
        $this->sequenceFactory = $sequenceFactory;
    }

    /**
     * Returns sequence for given entityType and store.
     *
     * @param string $entityType
     * @param int    $storeId      This is used to get the counter.
     * @param int    $orderStoreId
     *
     * @return \Magento\Framework\DB\Sequence\SequenceInterface
     */
    public function getSequence($entityType, $storeId, $orderStoreId)
    {
        return $this->sequenceFactory->create(
            [
                'entityType' => $entityType,
                'storeId' => $storeId,
                'orderStoreId' => $orderStoreId,
            ]
        );
    }
}
