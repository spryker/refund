<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Business\Model\RefundCalculator;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RefundTransfer;

class ExpenseRefundCalculator extends AbstractRefundCalculator
{
    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array<\Orm\Zed\Sales\Persistence\SpySalesOrderItem> $salesOrderItems
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function calculateRefund(RefundTransfer $refundTransfer, OrderTransfer $orderTransfer, array $salesOrderItems)
    {
        $refundableItemAmounts = [];

        foreach ($orderTransfer->getItems() as $itemTransfer) {
            $idSalesShipment = (int)$itemTransfer->getShipment()?->getIdSalesShipment();

            $refundableItemAmounts[$idSalesShipment] ??= 0;

            if ($this->isItemAdded($refundTransfer, $itemTransfer)) {
                continue;
            }

            if ($this->shouldItemRefunded($itemTransfer, $salesOrderItems)) {
                $refundTransfer->addItem($itemTransfer);

                continue;
            }

            $refundableItemAmounts[$idSalesShipment] += (int)$itemTransfer->getRefundableAmount();
        }

        $this->addRefundableExpenses($refundTransfer, $orderTransfer, $refundableItemAmounts);

        $this->calculateRefundableExpenseAmount($refundTransfer);
        $this->setCanceledExpenseAmount($refundTransfer);

        return $refundTransfer;
    }

    /**
     * @param array<int, int> $refundableItemAmounts
     */
    protected function addRefundableExpenses(
        RefundTransfer $refundTransfer,
        OrderTransfer $orderTransfer,
        array $refundableItemAmounts
    ): void {
        foreach ($orderTransfer->getExpenses() as $expenseTransfer) {
            if ((int)$expenseTransfer->getRefundableAmount() <= 0) {
                continue;
            }

            $idSalesShipment = (int)$expenseTransfer->getShipment()?->getIdSalesShipment();

            if (($refundableItemAmounts[$idSalesShipment] ?? null) !== 0) {
                continue;
            }

            $refundTransfer->addExpense($expenseTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    protected function calculateRefundableExpenseAmount(RefundTransfer $refundTransfer)
    {
        foreach ($refundTransfer->getExpenses() as $expenseTransfer) {
            $refundTransfer->setAmount($refundTransfer->getAmount() + $expenseTransfer->getRefundableAmount());
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    protected function setCanceledExpenseAmount(RefundTransfer $refundTransfer)
    {
        foreach ($refundTransfer->getExpenses() as $expenseTransfer) {
            $expenseTransfer->setCanceledAmount($expenseTransfer->getRefundableAmount());
        }
    }
}
