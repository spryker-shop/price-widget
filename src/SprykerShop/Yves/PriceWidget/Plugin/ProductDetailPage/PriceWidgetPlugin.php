<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PriceWidget\Plugin\ProductDetailPage;

use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidgetPlugin;
use SprykerShop\Yves\ProductDetailPage\Dependency\Plugin\PriceWidget\PriceWidgetPluginInterface;

/**
 * @method \SprykerShop\Yves\PriceWidget\PriceWidgetFactory getFactory()
 */
class PriceWidgetPlugin extends AbstractWidgetPlugin implements PriceWidgetPluginInterface
{
    /**
     * @see \Spryker\Zed\CustomerAccess\CustomerAccessConfig::CONTENT_TYPE_PRICE
     */
    const CONTENT_TYPE_PRICE = 'price';

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@PriceWidget/views/price/price.twig';
    }

    /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     *
     * @return void
     */
    public function initialize(ProductViewTransfer $productViewTransfer): void
    {
        $this->addParameter('product', $productViewTransfer);
    }
}
