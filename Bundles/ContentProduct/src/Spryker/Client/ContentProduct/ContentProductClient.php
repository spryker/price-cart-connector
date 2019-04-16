<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ContentProduct;

use Generated\Shared\Transfer\ContentProductAbstractListTypeTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Spryker\Client\ContentProduct\ContentProductFactory getFactory()
 */
class ContentProductClient extends AbstractClient implements ContentProductClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idContent
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ContentProductAbstractListTypeTransfer|null
     */
    public function executeProductAbstractListTypeById(int $idContent, string $localeName): ?ContentProductAbstractListTypeTransfer
    {
        return $this->getFactory()
            ->createContentProductAbstractListTypeMapper()
            ->executeProductAbstractListTypeById($idContent, $localeName);
    }
}