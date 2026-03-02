<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Refund\Presentation;

use SprykerTest\Zed\Refund\RefundPresentationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Refund
 * @group Presentation
 * @group RefundListCest
 * Add your own group annotations below this line
 */
class RefundListCest
{
    public function _before(RefundPresentationTester $i): void
    {
        $i->amZed();
        $i->amLoggedInUser();
    }

    public function testThatRefundListIsVisible(RefundPresentationTester $i): void
    {
        $i->canOpenRefundListPage();
    }
}
