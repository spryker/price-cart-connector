<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\Spryker\Zed\PriceCartConnector\Business\Fixture;

use Spryker\Shared\Kernel\LocatorLocatorInterface;
use Spryker\Shared\Cart\Transfer\ItemInterface;
use Spryker\Shared\Transfer\AbstractTransfer;

class CartItemFixture extends AbstractTransfer implements ItemInterface
{

    private $id;

    public function __construct(LocatorLocatorInterface $locator = null)
    {
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $identifier
     *
     * @return self
     */
    public function setId($identifier)
    {
        $this->id = $identifier;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        // TODO: Implement getQuantity() method.
    }

    /**
     * @param int $quantity
     *
     * @return self
     */
    public function setQuantity($quantity = 1)
    {
        // TODO: Implement setQuantity() method.
    }

}
