<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\PriceCartConnector\Business\Manager;

use Generated\Shared\Transfer\ChangeTransfer;

interface PriceManagerInterface
{

    /**
     * @param ChangeTransfer $change
     *
     * @return \Generated\Shared\Transfer\ChangeTransfer
     */
    public function addGrossPriceToItems(ChangeTransfer $change);

}
