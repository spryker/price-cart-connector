<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Content\Business;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\ContentBuilder;
use Generated\Shared\Transfer\ContentTransfer;
use Generated\Shared\Transfer\LocalizedContentTransfer;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Zed
 * @group Content
 * @group Business
 * @group Facade
 * @group ContentFacadeTest
 * Add your own group annotations below this line
 */
class ContentFacadeTest extends Test
{
    private const NAME = 'New name';
    private const PARAMENTERS = '{"sku"}';

    /**
     * @var \SprykerTest\Zed\Content\ContentBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testFindContentById(): void
    {
        $contentTransfer = $this->tester->haveContent();
        $foundContentTransfer = $this->getFacade()->findContentById($contentTransfer->getIdContent());

        $this->assertNotNull($foundContentTransfer->getIdContent());
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $contentTransfer = (new ContentBuilder(
            [
                ContentTransfer::LOCALIZED_CONTENTS => [
                    [
                        LocalizedContentTransfer::PARAMETERS => '{}',
                    ],
                ],
            ]
        ))->build();
        $createdContentTransfer = $this->getFacade()->create($contentTransfer);

        $this->assertNotNull($createdContentTransfer->getIdContent());
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $contentTransfer = $this->tester->haveContent();

        $contentTransfer->setName(static::NAME);
        $contentTransfer->getLocalizedContents()[0]->setParameters(static::PARAMENTERS);

        $this->getFacade()->update($contentTransfer);

        $updatedContentTransfer = $this->getFacade()->findContentById($contentTransfer->getIdContent());

        $this->assertEquals($contentTransfer->getName(), $updatedContentTransfer->getName());
        $this->assertEquals(
            $contentTransfer->getLocalizedContents()[0]->getParameters(),
            $updatedContentTransfer->getLocalizedContents()[0]->getParameters()
        );
    }

    /**
     * @return \Spryker\Zed\Content\Business\ContentFacadeInterface|\Spryker\Zed\Kernel\Business\AbstractFacade
     */
    protected function getFacade()
    {
        return $this->tester->getFacade();
    }
}