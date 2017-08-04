<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Client\Kernel;

use PHPUnit_Framework_TestCase;
use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;

/**
 * @group Functional
 * @group Spryker
 * @group Client
 * @group Kernel
 * @group AbstractDependencyProviderTest
 */
class AbstractDependencyProviderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $this->assertInstanceOf(Container::class, $abstractDependencyContainerMock->provideServiceLayerDependencies($container));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Client\Kernel\AbstractDependencyProvider
     */
    private function getAbstractDependencyContainerMock()
    {
        $abstractDependencyContainerMock = $this->getMockForAbstractClass(AbstractDependencyProvider::class);

        return $abstractDependencyContainerMock;
    }

}