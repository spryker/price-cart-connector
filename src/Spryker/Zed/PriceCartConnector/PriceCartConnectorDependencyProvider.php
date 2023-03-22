<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceCartConnector;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartConnectorToCurrencyFacadeBridge;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartConnectorToPriceProductAdapter;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartToMessengerFacadeBridge;
use Spryker\Zed\PriceCartConnector\Dependency\Facade\PriceCartToPriceBridge;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToPriceProductServiceBridge;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToUtilEncodingServiceBridge;
use Spryker\Zed\PriceCartConnector\Dependency\Service\PriceCartConnectorToUtilTextServiceBridge;

/**
 * @method \Spryker\Zed\PriceCartConnector\PriceCartConnectorConfig getConfig()
 */
class PriceCartConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_PRICE_PRODUCT = 'price product facade';

    /**
     * @var string
     */
    public const SERVICE_PRICE_PRODUCT = 'SERVICE_PRICE_PRODUCT';

    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const SERVICE_UTIL_TEXT = 'SERVICE_UTIL_TEXT';

    /**
     * @var string
     */
    public const FACADE_PRICE = 'price facade';

    /**
     * @var string
     */
    public const FACADE_MESSENGER = 'FACADE_MESSENGER';

    /**
     * @var string
     */
    public const FACADE_CURRENCY = 'FACADE_CURRENCY';

    /**
     * @var string
     */
    public const PLUGINS_PRICE_PRODUCT_EXPANDER = 'PLUGINS_PRICE_PRODUCT_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_CART_ITEM_QUANTITY_COUNTER_STRATEGY = 'PLUGINS_CART_ITEM_QUANTITY_COUNTER_STRATEGY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addPriceProductFacade($container);
        $container = $this->addPriceProductService($container);
        $container = $this->addUtilEncodingService($container);
        $container = $this->addUtilTextService($container);
        $container = $this->addPriceFacade($container);
        $container = $this->addMessengerFacade($container);
        $container = $this->addCurrencyFacade($container);
        $container = $this->addPriceProductExpanderPlugins($container);
        $container = $this->addCartItemQuantityCounterStrategyPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductFacade(Container $container)
    {
        $container->set(static::FACADE_PRICE_PRODUCT, function (Container $container) {
            return new PriceCartConnectorToPriceProductAdapter($container->getLocator()->priceProduct()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductService(Container $container): Container
    {
        $container->set(static::SERVICE_PRICE_PRODUCT, function (Container $container) {
            return new PriceCartConnectorToPriceProductServiceBridge($container->getLocator()->priceProduct()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new PriceCartConnectorToUtilEncodingServiceBridge(
                $container->getLocator()->utilEncoding()->service(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilTextService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_TEXT, function (Container $container) {
            return new PriceCartConnectorToUtilTextServiceBridge(
                $container->getLocator()->utilText()->service(),
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceFacade(Container $container)
    {
        $container->set(static::FACADE_PRICE, function (Container $container) {
            return new PriceCartToPriceBridge($container->getLocator()->price()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMessengerFacade(Container $container): Container
    {
        $container->set(static::FACADE_MESSENGER, function (Container $container) {
            return new PriceCartToMessengerFacadeBridge($container->getLocator()->messenger()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCurrencyFacade(Container $container): Container
    {
        $container->set(static::FACADE_CURRENCY, function (Container $container) {
            return new PriceCartConnectorToCurrencyFacadeBridge($container->getLocator()->currency()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceProductExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_PRICE_PRODUCT_EXPANDER, function () {
            return $this->getPriceProductExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCartItemQuantityCounterStrategyPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_CART_ITEM_QUANTITY_COUNTER_STRATEGY, function () {
            return $this->getCartItemQuantityCounterStrategyPlugins();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\CartItemQuantityCounterStrategyPluginInterface>
     */
    protected function getCartItemQuantityCounterStrategyPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Spryker\Zed\PriceCartConnectorExtension\Dependency\Plugin\PriceProductExpanderPluginInterface>
     */
    protected function getPriceProductExpanderPlugins(): array
    {
        return [];
    }
}
