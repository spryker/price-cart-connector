<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceCartConnector\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\PriceCartConnector\Business\Builder\ItemIdentifierBuilder;
use Spryker\Zed\PriceCartConnector\Business\Builder\ItemIdentifierBuilderInterface;
use Spryker\Zed\PriceCartConnector\Business\Filter\Comparator\ItemComparator;
use Spryker\Zed\PriceCartConnector\Business\Filter\Comparator\ItemComparatorInterface;
use Spryker\Zed\PriceCartConnector\Business\Filter\ItemFilterInterface;
use Spryker\Zed\PriceCartConnector\Business\Filter\ItemsWithoutPriceFilter;
use Spryker\Zed\PriceCartConnector\Business\Filter\PriceProductFilter;
use Spryker\Zed\PriceCartConnector\Business\Filter\PriceProductFilterInterface;
use Spryker\Zed\PriceCartConnector\Business\Manager\PriceManager;
use Spryker\Zed\PriceCartConnector\Business\Sanitizer\SourcePriceSanitizer;
use Spryker\Zed\PriceCartConnector\Business\Sanitizer\SourcePriceSanitizerInterface;
use Spryker\Zed\PriceCartConnector\Business\Validator\PriceProductValidator;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartConnectorToCurrencyFacadeInterface;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartToMessengerInterface;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToPriceProductServiceInterface;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToUtilEncodingServiceInterface;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToUtilTextServiceInterface;
use Spryker\Zed\PriceCartConnector\PriceCartConnectorDependencyProvider;

/**
 * @method \Spryker\Zed\PriceCartConnector\Business\PriceCartConnectorBusinessFactory getFactory()
 * @method \Spryker\Zed\PriceCartConnector\PriceCartConnectorConfig getConfig()
 */
class PriceCartConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\PriceCartConnector\Business\Manager\PriceManagerInterface
     */
    public function createPriceManager()
    {
        return new PriceManager(
            $this->getPriceProductFacade(),
            $this->getPriceFacade(),
            $this->createPriceProductFilter(),
            $this->getPriceProductService(),
            $this->getPriceProductExpanderPlugins(),
            $this->createItemIdentifierBuilder(),
            $this->createItemComparator(),
        );
    }

    /**
     * @return \Spryker\Zed\PriceCartConnector\Business\Validator\PriceProductValidatorInterface
     */
    public function createPriceProductValidator()
    {
        return new PriceProductValidator(
            $this->getPriceProductFacade(),
            $this->createPriceProductFilter(),
            $this->getConfig(),
            $this->createItemIdentifierBuilder(),
        );
    }

    public function createPriceProductFilter(): PriceProductFilterInterface
    {
        return new PriceProductFilter(
            $this->getPriceProductFacade(),
            $this->getPriceFacade(),
            $this->getCurrencyFacade(),
            $this->getCartItemQuantityCounterStrategyPlugins(),
            $this->createItemComparator(),
        );
    }

    public function createItemsWithoutPriceFilter(): ItemFilterInterface
    {
        return new ItemsWithoutPriceFilter(
            $this->getPriceFacade(),
            $this->getPriceProductFacade(),
            $this->getMessengerFacade(),
            $this->getPriceProductService(),
            $this->createItemIdentifierBuilder(),
        );
    }

    public function createSourcePriceSanitizer(): SourcePriceSanitizerInterface
    {
        return new SourcePriceSanitizer();
    }

    public function createItemComparator(): ItemComparatorInterface
    {
        return new ItemComparator($this->getConfig());
    }

    public function createItemIdentifierBuilder(): ItemIdentifierBuilderInterface
    {
        return new ItemIdentifierBuilder(
            $this->getConfig(),
            $this->getUtilEncodingService(),
            $this->getUtilTextService(),
        );
    }

    /**
     * @return \Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartToPriceProductInterface
     */
    protected function getPriceProductFacade()
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::FACADE_PRICE_PRODUCT);
    }

    /**
     * @return \Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartToPriceInterface
     */
    protected function getPriceFacade()
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::FACADE_PRICE);
    }

    public function getMessengerFacade(): PriceCartToMessengerInterface
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::FACADE_MESSENGER);
    }

    public function getCurrencyFacade(): PriceCartConnectorToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::FACADE_CURRENCY);
    }

    public function getPriceProductService(): PriceCartConnectorToPriceProductServiceInterface
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::SERVICE_PRICE_PRODUCT);
    }

    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\PriceProductExpanderPluginInterface>
     */
    public function getPriceProductExpanderPlugins(): array
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::PLUGINS_PRICE_PRODUCT_EXPANDER);
    }

    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\CartItemQuantityCounterStrategyPluginInterface>
     */
    public function getCartItemQuantityCounterStrategyPlugins(): array
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::PLUGINS_CART_ITEM_QUANTITY_COUNTER_STRATEGY);
    }

    public function getUtilEncodingService(): PriceCartConnectorToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    public function getUtilTextService(): PriceCartConnectorToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(PriceCartConnectorDependencyProvider::SERVICE_UTIL_TEXT);
    }
}
