<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Refund\Communication\Plugin\Sales;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\SalesDetailBlockRendererPluginInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Refund\Communication\RefundCommunicationFactory getFactory()
 * @method \Spryker\Zed\Refund\Business\RefundFacadeInterface getFacade()
 * @method \Spryker\Zed\Refund\RefundConfig getConfig()
 * @method \Spryker\Zed\Refund\Persistence\RefundRepositoryInterface getRepository()
 */
class RefundSalesListBlockRendererPlugin extends AbstractPlugin implements SalesDetailBlockRendererPluginInterface
{
    protected const string BLOCK_URL = '/refund/sales/list';

    /**
     * {@inheritDoc}
     * - Checks if the block URL is '/refund/sales/list'.
     *
     * @api
     *
     * @param string $blockUrl
     *
     * @return bool
     */
    public function isApplicable(string $blockUrl): bool
    {
        return $blockUrl === static::BLOCK_URL;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $blockUrl
     *
     * @return string
     */
    public function getTemplatePath(string $blockUrl): string
    {
        return '@Refund/Sales/list.twig';
    }

    /**
     * {@inheritDoc}
     * - Returns refunds for the order as template data.
     *
     * @api
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param string $blockUrl
     *
     * @return array<string, mixed>
     */
    public function getData(Request $request, OrderTransfer $orderTransfer, string $blockUrl): array
    {
        return [
            'refunds' => $this->getRepository()->getRefundsByIdSalesOrder($orderTransfer->getIdSalesOrder()),
            'order' => $orderTransfer,
        ];
    }
}
