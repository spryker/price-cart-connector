<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Cart\Dependency\Client;

class CartToMessengerClientBridge implements CartToMessengerClientInterface
{
    /**
     * @var \Spryker\Client\Messenger\MessengerClientInterface
     */
    protected $messengerClient;

    /**
     * @param \Spryker\Client\Messenger\MessengerClientInterface $messengerClient
     */
    public function __construct($messengerClient)
    {
        $this->messengerClient = $messengerClient;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $message
     *
     * @return void
     */
    public function addErrorMessage($message): void
    {
        $this->messengerClient->addErrorMessage($message);
    }
}
