<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\PriceProductOfferDataImport\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReaderConfigurationTransfer;
use Orm\Zed\PriceProductOffer\Persistence\SpyPriceProductOfferQuery;
use Spryker\Zed\PriceProductOfferDataImport\Communication\Plugin\PriceProductOfferDataImportPlugin;
use Spryker\Zed\PriceProductOfferDataImport\PriceProductOfferDataImportConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group PriceProductOfferDataImport
 * @group Communication
 * @group Plugin
 * @group PriceProductOfferDataImportPluginTest
 *
 * Add your own group annotations below this line
 */
class PriceProductOfferDataImportPluginTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\PriceProductOfferDataImport\PriceProductOfferDataImportCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testMerchantProfileDataImportFacade(): void
    {
        $dataImporterReaderConfigurationTransfer = new DataImporterReaderConfigurationTransfer();
        $dataImporterReaderConfigurationTransfer->setFileName(codecept_data_dir() . 'import/price_product_offer.csv');

        $dataImportConfigurationTransfer = new DataImporterConfigurationTransfer();
        $dataImportConfigurationTransfer->setReaderConfiguration($dataImporterReaderConfigurationTransfer);

        $dataImportPlugin = new PriceProductOfferDataImportPlugin();

        // Act
        $dataImportPlugin->import($dataImportConfigurationTransfer);

        // Assert

        $this->assertNotEmpty($this->getPriceProductOffer());
    }

    /**
     * @return void
     */
    public function testGetImportTypeReturnsTypeOfImporter(): void
    {
        // Arrange
        $dataImportPlugin = new PriceProductOfferDataImportPlugin();

        // Act
        $importType = $dataImportPlugin->getImportType();

        // Assert
        $this->assertSame(PriceProductOfferDataImportConfig::IMPORT_TYPE_PRICE_PRODUCT_OFFER, $importType);
    }

    /**
     * @return bool
     */
    protected function getPriceProductOffer(): bool
    {
        $priceProductOfferQuery = new SpyPriceProductOfferQuery();

        return $priceProductOfferQuery->exists();
    }
}
