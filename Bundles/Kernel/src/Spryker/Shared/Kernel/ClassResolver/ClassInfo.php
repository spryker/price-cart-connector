<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\ClassResolver;

class ClassInfo
{
    const KEY_NAMESPACE = 0;
    const KEY_APPLICATION = 1;
    const KEY_BUNDLE = 2;
    const KEY_LAYER = 3;

    /**
     * @var string
     */
    private $callerClassName;

    /**
     * @var string
     */
    protected $callerClassParts;

    /**
     * @var \Spryker\Shared\Kernel\ClassResolver\BundleNameResolver
     */
    protected $bundleNameResolver;

    /**
     * @param object|string $callerClass
     *
     * @return $this
     */
    public function setClass($callerClass)
    {
        if (is_object($callerClass)) {
            $callerClass = get_class($callerClass);
        }
        $this->callerClassName = $callerClass;

        $callerClassParts = [
            self::KEY_BUNDLE => $callerClass,
        ];

        if ($this->isFullyQualifiedClassName($callerClass)) {
            $callerClassParts = explode('\\', ltrim($callerClass, '\\'));
            $callerClassParts = $this->removeTestNamespace($callerClassParts);
        }

        $this->callerClassParts = $callerClassParts;

        return $this;
    }

    /**
     * @param string $callerClass
     *
     * @return bool
     */
    private function isFullyQualifiedClassName($callerClass)
    {
        return (strpos($callerClass, '\\') !== false);
    }

    /**
     * @return string
     */
    public function getCallerClassName()
    {
        return $this->callerClassName;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->callerClassParts[self::KEY_NAMESPACE];
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return $this->callerClassParts[self::KEY_APPLICATION];
    }

    /**
     * @return string
     */
    public function getBundle()
    {
        $bundleName = $this->callerClassParts[self::KEY_BUNDLE];
        $bundleName = $this->getBundleNameResolver()->resolve($bundleName);

        return $bundleName;
    }

    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\BundleNameResolver
     */
    protected function getBundleNameResolver()
    {
        if (!$this->bundleNameResolver) {
            $this->bundleNameResolver = new BundleNameResolver();
        }

        return $this->bundleNameResolver;
    }

    /**
     * @param array $callerClassParts
     *
     * @return array
     */
    private function removeTestNamespace(array $callerClassParts)
    {
        $namespace = $callerClassParts[self::KEY_NAMESPACE];
        $namespaceLength = strlen($namespace);

        $testNamespaceSuffix = 'Test';
        $testNamespaceSuffixLength = strlen($testNamespaceSuffix);

        if ($testNamespaceSuffixLength < $namespaceLength) {
            $isTestNamespace = substr_compare($namespace, $testNamespaceSuffix, $namespaceLength - $testNamespaceSuffixLength, $testNamespaceSuffixLength) === 0;
            if ($isTestNamespace) {
                $namespaceWithoutTestSuffix = substr($namespace, 0, -$testNamespaceSuffixLength);
                $callerClassParts[self::KEY_NAMESPACE] = $namespaceWithoutTestSuffix;
            }
        }

        return $callerClassParts;
    }

    /**
     * @return string
     */
    public function getLayer()
    {
        return $this->callerClassParts[self::KEY_LAYER];
    }
}