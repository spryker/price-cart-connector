<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductListStorage\ProductViewVariantRestrictionExpander;

use Generated\Shared\Transfer\ProductViewTransfer;

/**
 * @deprecated Will be removed without replacement. Do not use it with spryker/product-storage ^1.4.0.
 */
interface ProductViewVariantRestrictionExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductVariantData(ProductViewTransfer $productViewTransfer): ProductViewTransfer;
}
