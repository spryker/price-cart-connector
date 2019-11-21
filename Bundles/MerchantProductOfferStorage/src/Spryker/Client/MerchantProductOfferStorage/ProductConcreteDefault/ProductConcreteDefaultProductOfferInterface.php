<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Client\MerchantProductOfferStorage\ProductConcreteDefault;

use Generated\Shared\Transfer\ProductViewTransfer;

interface ProductConcreteDefaultProductOfferInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return string|null
     */
    public function findProductOfferReference(ProductViewTransfer $productViewTransfer): ?string;
}
