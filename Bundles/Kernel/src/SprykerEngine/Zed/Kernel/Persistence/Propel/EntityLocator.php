<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Zed\Kernel\Persistence\Propel;

use SprykerEngine\Shared\Kernel\CamelHumpClassResolver;
use SprykerEngine\Shared\Kernel\ClassResolver;
use SprykerEngine\Shared\Kernel\IdentityMapClassResolver;
use SprykerEngine\Shared\Kernel\Locator\LocatorInterface;
use SprykerEngine\Shared\Kernel\LocatorLocatorInterface;

class EntityLocator implements LocatorInterface
{

    /**
     * @var string
     */
    private $classNamePattern = '\\{{namespace}}\\Zed\\{{bundle}}{{store}}\\Persistence\\Propel\\';

    /**
     * @param string|null $classNamePattern
     */
    public function __construct($classNamePattern = null)
    {
        if (!is_null($classNamePattern)) {
            $this->classNamePattern = $classNamePattern;
        }
    }

    /**
     * @param string $bundle
     * @param LocatorLocatorInterface $locator
     * @param null|string $className
     *
     * @return object
     * @throws ClassResolver\ClassNameAmbiguousException
     * @throws ClassResolver\ClassNotFoundException
     */
    public function locate($bundle, LocatorLocatorInterface $locator, $className = null)
    {
        $classToLocate = $this->classNamePattern . $className;
        $classResolver = new ClassResolver();
        $camelHumpClassResolver = new CamelHumpClassResolver($classResolver);
        $identityMapResolver = IdentityMapClassResolver::getInstance($camelHumpClassResolver);

        $resolvedTransfer = $identityMapResolver->resolve($classToLocate, $bundle);

        return $resolvedTransfer;
    }

    /**
     * @param string $bundle
     *
     * @return boolean
     * @throws \ErrorException
     */
    public function canLocate($bundle)
    {
        throw new \ErrorException('Not available here');
    }
}
