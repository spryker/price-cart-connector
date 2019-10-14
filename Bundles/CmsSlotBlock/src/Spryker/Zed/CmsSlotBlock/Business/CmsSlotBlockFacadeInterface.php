<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlock\Business;

use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;

interface CmsSlotBlockFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer
     */
    public function saveCmsSlotBlockRelations(CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer): void;
}
