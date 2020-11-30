<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Model\Config\Source;

class Frequency implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected static $_options;

    const CRON_NO = '';

    const CRON_DAILY = 'D';

    const CRON_WEEKLY = 'W';

    const CRON_MONTHLY = 'M';

    const CRON_YEARLY = 'Y';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!self::$_options) {
            self::$_options = [
                ['label' => __('No'), 'value' => self::CRON_NO],
                ['label' => __('Daily'), 'value' => self::CRON_DAILY],
                ['label' => __('Weekly'), 'value' => self::CRON_WEEKLY],
                ['label' => __('Monthly'), 'value' => self::CRON_MONTHLY],
                ['label' => __('Yearly'), 'value' => self::CRON_YEARLY],
            ];
        }

        return self::$_options;
    }
}
