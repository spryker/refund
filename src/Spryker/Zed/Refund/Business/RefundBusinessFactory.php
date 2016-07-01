<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Refund\Business\Model\RefundCalculator;
use Spryker\Zed\Refund\Business\Model\RefundSaver;
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
            $this->getSalesAggregatorFacade(),
            $this->getRefundCalculatorPlugin()
        );
    }

    /**
     * @return \Spryker\Zed\Refund\Business\Model\RefundSaverInterface
     */
    public function createRefundSaver()
    {
        return new RefundSaver(
            $this->getSalesQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\Refund\Dependency\Facade\RefundToSalesAggregatorInterface
     */
    protected function getSalesAggregatorFacade()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::FACADE_SALES_AGGREGATOR);
    }

    /**
     * @return \Spryker\Zed\Refund\Communication\Plugin\RefundCalculatorPluginInterface
     */
    protected function getRefundCalculatorPlugin()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::PLUGIN_REFUND_CALCULATOR);
    }

    /**
     * @return \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected function getSalesQueryContainer()
    {
        return $this->getProvidedDependency(RefundDependencyProvider::QUERY_CONTAINER_SALES);
    }

}
