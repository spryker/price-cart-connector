<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\UrlStorage;

use Spryker\Shared\Kernel\AbstractSharedConfig;

class UrlStorageConfig extends AbstractSharedConfig
{
    /**
     * Defines queue name that as used for asynchronous event handling.
     */
    public const PUBLISH_URL = 'publish.url';

    /**
     * Defines error queue name as used when with asynchronous event handling
     */
    public const PUBLISH_URL_ERROR_QUEUE = 'publish.url.error';

    /**
     * Defines retry queue name as used when with asynchronous event handling.
     */
    public const PUBLISH_URL_RETRY_QUEUE = 'publish.url.retry';
}
