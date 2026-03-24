<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Persistence;

use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;

interface RefundRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Propel\Runtime\Collection\ObjectCollection|\Propel\Runtime\Collection\Collection<\Generated\Shared\Transfer\RefundTransfer>
     */
    public function getRefundsByIdSalesOrder(int $idSalesOrder): ObjectCollection|Collection;
}
