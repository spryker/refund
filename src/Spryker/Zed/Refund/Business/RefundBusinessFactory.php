<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Refund\Business\Model\RefundCalculator;
use Spryker\Zed\Refund\Business\Model\RefundCalculator\ExpenseRefundCalculator;
use Spryker\Zed\Refund\Business\Model\RefundCalculator\ItemRefundCalculator;
use Spryker\Zed\Refund\Business\Model\RefundSaver;
use Spryker\Zed\Refund\Dependency\Facade\RefundToMessengerFacadeInterface;
use Spryker\Zed\Refund\RefundDependencyProvider;

/**
 * @method \Spryker\Zed\Refund\Persistence\RefundQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Refund\RefundConfig getConfig()
 */
class RefundBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\Refund\Business\Model\RefundCalculatorInterface
     */
    public function createRefundCalculator()
    {
        return new RefundCalculator(
            $this->getRefundCalculatorPlugins(),
            $this->getSalesFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\Refund\Business\Model\RefundCalculator\RefundCalculatorInterface
     */
    public function createItemRefundCalculator()
    {
        return new ItemRefundCalculator();
    }

    /**
     * @return \Spryker\Zed\Refund\Business\Model\RefundCalculator\RefundCalculatorInterface
     */
    public function createExpenseRefundCalculator()
    {
        return new ExpenseRefundCalculator();
    }

    /**
     * @return \Spryker\Zed\Refund\Business\Model\RefundSaverInterface
     */
    public function createRefundSaver()
    {
        return new RefundSaver(
            $this->getSalesQueryContainer(),
            $this->getSalesFacade(),
            $this->getCalculationFacade(),
            $this->getConfig(),
            $this->getMessengerFacade(),
            $this->getRefundPostSavePlugins(),
        );
    }

    /**
     * @return \Spryker\Zed\Refund\Dependency\Facade\RefundToSalesInterface
     */
    protected function getSalesFacade()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \Spryker\Zed\Refund\Dependency\Facade\RefundToCalculationInterface
     */
    protected function getCalculationFacade()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_CALCULATION);
    }

    /**
     * @return array<\Spryker\Zed\Refund\Dependency\Plugin\RefundCalculatorPluginInterface>
     */
    protected function getRefundCalculatorPlugins()
    {
        return [
            $this->getProvidedDependency(RefundDependencyProvider::PLUGIN_ITEM_REFUND_CALCULATOR),
            $this->getProvidedDependency(RefundDependencyProvider::PLUGIN_EXPENSE_REFUND_CALCULATOR),
        ];
    }

    /**
     * @return \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::QUERY_CONTAINER_SALES);
    }

    /**
     * @return array<\Spryker\Zed\RefundExtension\Dependency\Plugin\RefundPostSavePluginInterface>
     */
    public function getRefundPostSavePlugins(): array
    {
        return $this->getProvidedDependency(RefundDependencyProvider::PLUGINS_REFUND_POST_SAVE);
    }

    /**
     * @return \Spryker\Zed\Refund\Dependency\Facade\RefundToMessengerFacadeInterface
     */
    protected function getMessengerFacade(): RefundToMessengerFacadeInterface
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_MESSENGER);
    }
}
