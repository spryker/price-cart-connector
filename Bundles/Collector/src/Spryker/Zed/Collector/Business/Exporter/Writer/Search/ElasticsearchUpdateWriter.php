<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Collector\Business\Exporter\Writer\Search;

use Elastica\Client;
use Elastica\Document;
use Spryker\Zed\Collector\Business\Exporter\Writer\WriterInterface;

class ElasticsearchUpdateWriter implements WriterInterface
{

    /**
     * @var \Elastica\Client
     */
    protected $client;

    /**
     * @var \Elastica\Index
     */
    protected $index;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param \Elastica\Client $searchClient
     * @param string $indexName
     * @param string $type
     */
    public function __construct(Client $searchClient, $indexName, $type)
    {
        $this->client = $searchClient;
        $this->index = $this->client->getIndex($indexName);
        $this->type = $type;
    }

    /**
     * @param array $dataSet
     *
     * @return bool
     */
    public function write(array $dataSet)
    {
        $type = $this->index->getType($this->type);

        $type->updateDocuments($this->createDocuments($dataSet));
        $response = $type->getIndex()->refresh();

        return $response->isOk();
    }

    /**
     * @param array $dataSet
     *
     * @return void
     */
    public function delete(array $dataSet)
    {
    }

    /**
     * @param array $dataSet
     *
     * @return \Elastica\Document[]
     */
    protected function createDocuments(array $dataSet)
    {
        $documentPrototype = new Document();
        $documents = [];

        foreach ($dataSet as $key => $data) {
            $document = clone $documentPrototype;
            $document->setId($key);
            $document->setData($data);
            $documents[] = $document;
        }

        return $documents;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elasticsearch-update-writer';
    }

}