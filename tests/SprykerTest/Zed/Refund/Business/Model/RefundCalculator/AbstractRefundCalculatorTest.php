<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Refund\Business\Model\RefundCalculator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Refund
 * @group Business
 * @group Model
 * @group RefundCalculator
 * @group AbstractRefundCalculatorTest
 * Add your own group annotations below this line
 */
class AbstractRefundCalculatorTest extends Unit
{
    protected const int ID_SALES_SHIPMENT_ONE = 11;

    protected const int ID_SALES_SHIPMENT_TWO = 22;

    protected const int ID_SALES_EXPENSE_ONE = 1;

    protected const int ID_SALES_EXPENSE_TWO = 2;

    protected function getOrderTransferWithoutRefundedItems(): OrderTransfer
    {
        $orderTransfer = new OrderTransfer();

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setRefundableAmount(100);
        $itemTransfer->setIdSalesOrderItem(1);
        $orderTransfer->addItem($itemTransfer);

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setRefundableAmount(100);
        $itemTransfer->setIdSalesOrderItem(2);
        $orderTransfer->addItem($itemTransfer);

        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setRefundableAmount(10);
        $orderTransfer->addExpense($expenseTransfer);

        return $orderTransfer;
    }

    protected function getOrderTransferWithRefundedItem(): OrderTransfer
    {
        $orderTransfer = new OrderTransfer();

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setRefundableAmount(0);
        $itemTransfer->setIdSalesOrderItem(1);
        $orderTransfer->addItem($itemTransfer);

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setRefundableAmount(100);
        $itemTransfer->setIdSalesOrderItem(2);
        $orderTransfer->addItem($itemTransfer);

        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setRefundableAmount(10);
        $orderTransfer->addExpense($expenseTransfer);

        return $orderTransfer;
    }

    protected function getOrderTransferWithTwoShipments(): OrderTransfer
    {
        $orderTransfer = new OrderTransfer();

        $orderTransfer->addItem($this->createItemTransfer(1, 100, static::ID_SALES_SHIPMENT_ONE));
        $orderTransfer->addItem($this->createItemTransfer(2, 100, static::ID_SALES_SHIPMENT_ONE));
        $orderTransfer->addItem($this->createItemTransfer(3, 100, static::ID_SALES_SHIPMENT_TWO));

        $orderTransfer->addExpense($this->createShipmentExpenseTransfer(static::ID_SALES_EXPENSE_ONE, 10, static::ID_SALES_SHIPMENT_ONE));
        $orderTransfer->addExpense($this->createShipmentExpenseTransfer(static::ID_SALES_EXPENSE_TWO, 20, static::ID_SALES_SHIPMENT_TWO));

        return $orderTransfer;
    }

    protected function getOrderTransferWithTwoShipmentsAndFullyRefundedFirstShipment(): OrderTransfer
    {
        $orderTransfer = new OrderTransfer();

        $orderTransfer->addItem($this->createItemTransfer(1, 0, static::ID_SALES_SHIPMENT_ONE));
        $orderTransfer->addItem($this->createItemTransfer(2, 0, static::ID_SALES_SHIPMENT_ONE));
        $orderTransfer->addItem($this->createItemTransfer(3, 100, static::ID_SALES_SHIPMENT_TWO));

        $refundedExpenseTransfer = $this->createShipmentExpenseTransfer(static::ID_SALES_EXPENSE_ONE, 0, static::ID_SALES_SHIPMENT_ONE);
        $refundedExpenseTransfer->setCanceledAmount(10);
        $orderTransfer->addExpense($refundedExpenseTransfer);

        $orderTransfer->addExpense($this->createShipmentExpenseTransfer(static::ID_SALES_EXPENSE_TWO, 20, static::ID_SALES_SHIPMENT_TWO));

        return $orderTransfer;
    }

    protected function createItemTransfer(int $idSalesOrderItem, int $refundableAmount, int $idSalesShipment): ItemTransfer
    {
        return (new ItemTransfer())
            ->setIdSalesOrderItem($idSalesOrderItem)
            ->setRefundableAmount($refundableAmount)
            ->setShipment((new ShipmentTransfer())->setIdSalesShipment($idSalesShipment));
    }

    protected function createShipmentExpenseTransfer(int $idSalesExpense, int $refundableAmount, int $idSalesShipment): ExpenseTransfer
    {
        return (new ExpenseTransfer())
            ->setIdSalesExpense($idSalesExpense)
            ->setRefundableAmount($refundableAmount)
            ->setShipment((new ShipmentTransfer())->setIdSalesShipment($idSalesShipment));
    }

    protected function getSalesOrderItemOne(): SpySalesOrderItem
    {
        $salesOrderItem = new SpySalesOrderItem();
        $salesOrderItem->setIdSalesOrderItem(1);

        return $salesOrderItem;
    }

    protected function getSalesOrderItemTwo(): SpySalesOrderItem
    {
        $salesOrderItem = new SpySalesOrderItem();
        $salesOrderItem->setIdSalesOrderItem(2);

        return $salesOrderItem;
    }

    protected function getSalesOrderItemThree(): SpySalesOrderItem
    {
        $salesOrderItem = new SpySalesOrderItem();
        $salesOrderItem->setIdSalesOrderItem(3);

        return $salesOrderItem;
    }

    protected function getRefundTransferWithAmountAndItem(int $amount = 100, ?ItemTransfer $itemTransfer = null): RefundTransfer
    {
        $refundTransfer = new RefundTransfer();
        $refundTransfer->setAmount($amount);

        if ($itemTransfer === null) {
            $itemTransfer = new ItemTransfer();
            $itemTransfer->setIdSalesOrderItem(1);
        }

        $refundTransfer->addItem($itemTransfer);

        return $refundTransfer;
    }
}
