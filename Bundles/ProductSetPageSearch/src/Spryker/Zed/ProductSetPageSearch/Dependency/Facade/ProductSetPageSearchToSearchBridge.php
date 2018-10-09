<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductSetPageSearch\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Search\Dependency\Plugin\PageMapInterface;

class ProductSetPageSearchToSearchBridge implements ProductSetPageSearchToSearchInterface
{
    /**
     * @var \Spryker\Zed\Search\Business\SearchFacadeInterface
     */
    protected $searchFacade;

    /**
     * @param \Spryker\Zed\Search\Business\SearchFacadeInterface $searchFacade
     */
    public function __construct($searchFacade)
    {
        $this->searchFacade = $searchFacade;
    }

    /**
     * @param \Spryker\Zed\Search\Dependency\Plugin\PageMapInterface $pageMap
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return array
     */
    public function transformPageMapToDocument(PageMapInterface $pageMap, array $data, LocaleTransfer $localeTransfer)
    {
        return $this->searchFacade->transformPageMapToDocument($pageMap, $data, $localeTransfer);
    }

    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param string $mapperName
     *
     * @return array
     */
    public function transformPageMapToDocumentByMapperName(array $data, LocaleTransfer $localeTransfer, $mapperName)
    {
        return $this->searchFacade->transformPageMapToDocumentByMapperName($data, $localeTransfer, $mapperName);
    }
}