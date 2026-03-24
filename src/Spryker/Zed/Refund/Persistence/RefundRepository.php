<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Persistence;

use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\Refund\Persistence\RefundPersistenceFactory getFactory()
 */
class RefundRepository extends AbstractRepository implements RefundRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Propel\Runtime\Collection\ObjectCollection|\Propel\Runtime\Collection\Collection<\Generated\Shared\Transfer\RefundTransfer>
     */
    public function getRefundsByIdSalesOrder(int $idSalesOrder): ObjectCollection|Collection
    {
        return $this->getFactory()
            ->createRefundQuery()
            ->filterByFkSalesOrder($idSalesOrder)
            ->find();
    }
}
