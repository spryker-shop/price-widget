<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\PriceWidget\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use SprykerShop\Yves\PriceWidget\Exception\UnknownPriceModeException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\PriceWidget\PriceWidgetFactory getFactory()
 */
class PriceModeSwitchController extends AbstractController
{
    const URL_PARAM_PRICE_MODE = 'price-mode';
    const URL_PARAM_REFERRER_URL = 'referrer-url';
    const PRICE_MODE_SWITCH_ERROR_TRANSLATION_KEY = 'price.mode.switch.error';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $priceMode = $request->get(static::URL_PARAM_PRICE_MODE);

        $quoteTransfer = $this->getFactory()->getQuoteClient()->getQuote();
        if (count($quoteTransfer->getItems()) > 0) {
            $this->addErrorMessage(static::PRICE_MODE_SWITCH_ERROR_TRANSLATION_KEY);
            return $this->createRedirectResponse($request);
        }

        $this->switchPriceMode($priceMode);

        return $this->createRedirectResponse($request);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function createRedirectResponse(Request $request)
    {
        return $this->redirectResponseExternal(
            urldecode($request->get(static::URL_PARAM_REFERRER_URL))
        );
    }

    /**
     * @param string $priceMode
     *
     * @throws \SprykerShop\Yves\PriceWidget\Exception\UnknownPriceModeException
     *
     * @return void
     */
    protected function switchPriceMode($priceMode)
    {
        $priceModes = $this->getFactory()->getPriceClient()->getPriceModes();

        if (!isset($priceModes[$priceMode])) {
            throw new UnknownPriceModeException(sprintf(
                'Unknown price mode "%s".',
                $priceMode
            ));
        }

        $quoteTransfer = $this->getFactory()->getQuoteClient()->getQuote();
        $quoteTransfer->setPriceMode($priceMode);
        $this->getFactory()->getQuoteClient()->setQuote($quoteTransfer);
    }
}
