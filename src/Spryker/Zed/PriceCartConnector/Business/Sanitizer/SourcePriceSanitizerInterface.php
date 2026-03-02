<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceCartConnector\Business\Sanitizer;

use Generated\Shared\Transfer\QuoteTransfer;

interface SourcePriceSanitizerInterface
{
    public function sanitizeSourcePrices(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
