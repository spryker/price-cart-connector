<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceCartConnector\Business;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface PriceCartConnectorFacadeInterface
{
    /**
     * Specification:
     *  - Adds product prices to item, based on currency, price mode and price type.
     *  - Executes PriceProductExpanderPluginInterface plugin stack.
     *  - Executes CartItemQuantityCounterStrategyPluginInterface plugin stack.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     * @param string|null $priceType
     * @param bool|null $ignorePriceMissingException
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function addPriceToItems(CartChangeTransfer $cartChangeTransfer, $priceType = null, ?bool $ignorePriceMissingException = false);

    /**
     * Specification:
     *  - Validates product prices, checks if prices are valid for current currency, price mode, price type combination
     *  - Writes error message to response transfer if not valid.
     *  - Filters out price products with zero price if {@link \Spryker\Zed\PriceCartConnector\PriceCartConnectorConfig::isZeroPriceEnabledForCartActions()} set to `false`.
     *  - Executes CartItemQuantityCounterStrategyPluginInterface plugin stack.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartPreCheckResponseTransfer
     */
    public function validatePrices(CartChangeTransfer $cartChangeTransfer);

    /**
     * Specification:
     *  - Removes items without price from quote.
     *  - Adds note to messages about removed items.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function filterItemsWithoutPrice(QuoteTransfer $quoteTransfer): QuoteTransfer;

    /**
     * Specification:
     * - Sets unit source prices as null in quote items.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function sanitizeSourcePrices(QuoteTransfer $quoteTransfer): QuoteTransfer;
}
