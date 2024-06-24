<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class RefundConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Sanitizes recalculation messages after refund if set to true.
     *
     * @api
     *
     * @return bool
     */
    public function shouldCleanupRecalculationMessagesAfterRefund(): bool
    {
        return false;
    }
}
