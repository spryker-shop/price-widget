<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PriceWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\PriceWidget\Dependency\Client\PriceWidgetToPriceClientBridge;
use SprykerShop\Yves\PriceWidget\Dependency\Client\PriceWidgetToPriceStorageClientBridge;
use SprykerShop\Yves\PriceWidget\Dependency\Client\PriceWidgetToQuoteClientBridge;

class PriceWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    const CLIENT_PRICE_STORAGE = 'CLIENT_PRICE_STORAGE';
    const CLIENT_QUOTE = 'CLIENT_QUOTE';
    const CLIENT_PRICE = 'CLIENT_PRICE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addPriceStorageClient($container);
        $container = $this->addQuoteClient($container);
        $container = $this->addPriceClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPriceStorageClient(Container $container)
    {
        $container[self::CLIENT_PRICE_STORAGE] = function (Container $container) {
            return new PriceWidgetToPriceStorageClientBridge($container->getLocator()->priceStorage()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addQuoteClient(Container $container)
    {
        $container[self::CLIENT_QUOTE] = function (Container $container) {
            return new PriceWidgetToQuoteClientBridge($container->getLocator()->quote()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPriceClient(Container $container)
    {
        $container[self::CLIENT_PRICE] = function (Container $container) {
            return new PriceWidgetToPriceClientBridge($container->getLocator()->price()->client());
        };

        return $container;
    }
}
