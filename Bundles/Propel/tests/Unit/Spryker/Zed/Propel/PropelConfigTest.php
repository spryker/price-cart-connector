<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Propel;

use PHPUnit_Framework_TestCase;
use Spryker\Zed\Propel\Business\Exception\UnSupportedDatabaseEngineException;
use Spryker\Zed\Propel\PropelConfig;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Propel
 * @group PropelConfigTest
 */
class PropelConfigTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return \Spryker\Zed\Propel\PropelConfig
     */
    private function getConfig()
    {
        return new PropelConfig();
    }

    /**
     * @return void
     */
    public function testGetGeneratedDirectoryShouldReturnPathToGeneratedFiles()
    {
        $this->assertTrue(is_dir($this->getConfig()->getGeneratedDirectory()));
    }

    /**
     * @return void
     */
    public function getPropelConfig()
    {
        $this->assertInternalType('array', $this->getConfig()->getPropelConfig());
    }

    /**
     * @return void
     */
    public function testGetSchemaDirectoryShouldReturnPathToSchemas()
    {
        $this->assertTrue(is_dir($this->getConfig()->getSchemaDirectory()));
    }

    /**
     * @return void
     */
    public function testGetPropelSchemaPathPatterShouldReturnArrayWithPatternsToSchemaDirectories()
    {
        $pathPatterns = $this->getConfig()->getPropelSchemaPathPatterns();
        $this->assertTrue(is_array($pathPatterns));
    }

    /**
     * @return void
     */
    public function testGetLogPath()
    {
        $this->assertInternalType('string', $this->getConfig()->getLogPath());
    }

    /**
     * @return void
     */
    public function testGetCurrentDatabaseEngine()
    {
        $this->assertInternalType('string', $this->getConfig()->getCurrentDatabaseEngine());
    }

    /**
     * @return void
     */
    public function testGetCurrentDatabaseEngineName()
    {
        $this->assertInternalType('string', $this->getConfig()->getCurrentDatabaseEngineName());
    }

    /**
     * @return void
     */
    public function testGetCurrentDatabaseEngineNameThrowsException()
    {
        $propelConfigMock = $this->getPropelConfigMock();

        $this->expectException(UnSupportedDatabaseEngineException::class);
        $propelConfigMock->getCurrentDatabaseEngineName();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Propel\PropelConfig
     */
    protected function getPropelConfigMock()
    {
        $propelConfigMock = $this->getMockBuilder(PropelConfig::class)->setMethods(['getCurrentDatabaseEngine'])->getMock();
        $propelConfigMock->expects($this->once())->method('getCurrentDatabaseEngine')->willReturn('Un supported database engine');
        return $propelConfigMock;
    }

}