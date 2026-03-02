<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Refund\Business;

use Codeception\Test\Unit;
use Spryker\Zed\Refund\Business\Model\RefundCalculator\RefundCalculatorInterface as ConcreteCalculatorInterface;
use Spryker\Zed\Refund\Business\Model\RefundCalculatorInterface;
use Spryker\Zed\Refund\Business\Model\RefundSaverInterface;
use Spryker\Zed\Refund\Business\RefundBusinessFactory;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Refund
 * @group Business
 * @group RefundBusinessFactoryTest
 * Add your own group annotations below this line
 */
class RefundBusinessFactoryTest extends Unit
{
    public function testCreateRefundCalculatorShouldReturnRefundCalculatorInterface(): void
    {
        $refundCalculationFactory = new RefundBusinessFactory();

        $this->assertInstanceOf(RefundCalculatorInterface::class, $refundCalculationFactory->createRefundCalculator());
    }

    public function testCreateItemRefundCalculatorShouldReturnRefundCalculatorInterface(): void
    {
        $refundCalculationFactory = new RefundBusinessFactory();

        $this->assertInstanceOf(ConcreteCalculatorInterface::class, $refundCalculationFactory->createItemRefundCalculator());
    }

    public function testCreateExpenseRefundCalculatorShouldReturnRefundCalculatorInterface(): void
    {
        $refundCalculationFactory = new RefundBusinessFactory();

        $this->assertInstanceOf(ConcreteCalculatorInterface::class, $refundCalculationFactory->createExpenseRefundCalculator());
    }

    public function testCreateRefundSaverShouldReturnRefundSaverInterface(): void
    {
        $refundCalculationFactory = new RefundBusinessFactory();

        $this->assertInstanceOf(RefundSaverInterface::class, $refundCalculationFactory->createRefundSaver());
    }
}
