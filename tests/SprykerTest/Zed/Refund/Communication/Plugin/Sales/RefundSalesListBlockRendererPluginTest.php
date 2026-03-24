<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Refund\Communication\Plugin\Sales;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Refund\Persistence\SpyRefund;
use Spryker\Zed\Refund\Communication\Plugin\Sales\RefundSalesListBlockRendererPlugin;
use SprykerTest\Zed\Refund\RefundCommunicationTester;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Refund
 * @group Communication
 * @group Plugin
 * @group Sales
 * @group RefundSalesListBlockRendererPluginTest
 * Add your own group annotations below this line
 */
class RefundSalesListBlockRendererPluginTest extends Unit
{
    protected const string BLOCK_URL = '/refund/sales/list';

    protected const string OTHER_URL = '/other/url';

    protected const string DEFAULT_OMS_PROCESS_NAME = 'Test01';

    protected RefundCommunicationTester $tester;

    public function testIsApplicableReturnsTrueForMatchingUrl(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->isApplicable(static::BLOCK_URL);

        // Assert
        $this->assertTrue($result);
    }

    public function testIsApplicableReturnsFalseForNonMatchingUrl(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->isApplicable(static::OTHER_URL);

        // Assert
        $this->assertFalse($result);
    }

    public function testGetTemplatePathReturnsExpectedPath(): void
    {
        // Arrange
        $plugin = $this->getBlockRendererPlugin();

        // Act
        $result = $plugin->getTemplatePath(static::BLOCK_URL);

        // Assert
        $this->assertSame('@Refund/Sales/list.twig', $result);
    }

    public function testGetDataReturnsRefundsForOrderWithRefunds(): void
    {
        // Arrange
        $this->tester->configureTestStateMachine([static::DEFAULT_OMS_PROCESS_NAME]);
        $saveOrderTransfer = $this->tester->haveOrder([], static::DEFAULT_OMS_PROCESS_NAME);

        $refundEntity = (new SpyRefund())
            ->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder())
            ->setAmount(1000);
        $refundEntity->save();

        $plugin = $this->getBlockRendererPlugin();
        $orderTransfer = (new OrderTransfer())->setIdSalesOrder($saveOrderTransfer->getIdSalesOrder());

        // Act
        $result = $plugin->getData(new Request(), $orderTransfer, static::BLOCK_URL);

        // Assert
        $this->assertCount(1, $result['refunds']);
        $this->assertSame($saveOrderTransfer->getIdSalesOrder(), $result['order']->getIdSalesOrder());
    }

    public function getBlockRendererPlugin(): RefundSalesListBlockRendererPlugin
    {
        return new RefundSalesListBlockRendererPlugin();
    }
}
