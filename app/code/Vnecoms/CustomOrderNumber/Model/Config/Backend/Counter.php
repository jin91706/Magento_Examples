<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Model\Config\Backend;

use Vnecoms\CustomOrderNumber\Model\Config\Source\Frequency;

class Counter extends \Magento\Framework\App\Config\Value
{
    /**
     * Cron string path.
     */
    const CRON_STRING_PATH = 'crontab/default/jobs/vnecoms_order_num_reset_%s_counter/schedule/cron_expr';

    /**
     * @var \Magento\Framework\App\Config\ValueFactory
     */
    protected $_configValueFactory;

    /**
     * @param \Magento\Framework\Model\Context                        $context
     * @param \Magento\Framework\Registry                             $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface      $config
     * @param \Magento\Framework\App\Cache\TypeListInterface          $cacheTypeList
     * @param \Magento\Framework\App\Config\ValueFactory              $configValueFactory
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection
     * @param string                                                  $runModelPath
     * @param array                                                   $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_configValueFactory = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function afterSave()
    {
        $entityType = $this->getData('group_id');
        $frequency = $this->getData('groups/'.$entityType.'/fields/auto_reset_counter/value');

        switch ($frequency) {
            case Frequency::CRON_DAILY:
                $cronExprArray = [0, 0, '*', '*', '*'];
                break;
            case Frequency::CRON_WEEKLY:
                $cronExprArray = [0, 0, '*', '*', 0];
                break;
            case Frequency::CRON_MONTHLY:
                $cronExprArray = [0, 0, 1, '*', '*'];
                break;
            case Frequency::CRON_YEARLY:
                $cronExprArray = [0, 0, 1, 1, '*'];
                break;
            default:
                $cronExprArray = [];
        }

        $cronExprString = implode(' ', $cronExprArray);

        try {
            $this->_configValueFactory->create()->load(
                sprintf(self::CRON_STRING_PATH, $entityType),
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                sprintf(self::CRON_STRING_PATH, $entityType)
            )->save();
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t save the cron expression.'));
        }

        return parent::afterSave();
    }
}
