<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vnecoms\CustomOrderNumber\Cron;

class ResetCreditmemoNum extends AbstractCron
{
    /**
     * Run process send product alerts.
     *
     * @return $this
     */
    public function process()
    {
        $this->resetCounter('creditmemo');

        return $this;
    }
}
