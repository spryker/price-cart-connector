<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesReturnExtension\Dependency\Plugin;

use ArrayObject;

interface ReturnPolicyPluginInterface
{
    /**
     * Specification:
     * - Removes non-returnable order items from provided array of ItemTransfers.
     *
     * @api
     *
     * @param \ArrayObject|\Generated\Shared\Transfer\ItemTransfer[] $itemTransfers
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\ItemTransfer[]
     */
    public function execute(ArrayObject $itemTransfers): ArrayObject;
}
