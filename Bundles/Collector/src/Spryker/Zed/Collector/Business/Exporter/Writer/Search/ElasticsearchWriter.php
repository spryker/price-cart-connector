<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Collector\Business\Exporter\Writer\Search;

use Elastica\Client;
use Elastica\Document;
use Elastica\Exception\NotFoundException;
use Spryker\Zed\Collector\Business\Exporter\Exception\InvalidDataSetException;
use Spryker\Zed\Collector\Business\Exporter\Writer\WriterInterface;

class ElasticsearchWriter implements WriterInterface
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
     * @throws \Spryker\Zed\Collector\Business\Exporter\Exception\InvalidDataSetException
     *
     * @return bool
     */
    public function write(array $dataSet)
    {
        if ($this->hasIntegerKeys($dataSet)) {
            throw new InvalidDataSetException();
        }

        //@todo this is wrong, the touched type does not directly map to the processed type
        $type = $this->index->getType($this->type);
        $documents = $this->createDocuments($dataSet);
        $type->addDocuments($documents);
        $response = $type->getIndex()->refresh();

        return $response->isOk();
    }

    /**
     * @param array $dataSet
     *
     * @throws \Spryker\Zed\Collector\Business\Exporter\Exception\InvalidDataSetException
     *
     * @return bool
     */
    public function delete(array $dataSet)
    {
        if ($this->hasIntegerKeys($dataSet)) {
            throw new InvalidDataSetException();
        }

        $documents = [];
        foreach ($dataSet as $key => $value) {
            try {
                $documents[] = $this->index->getType($this->type)->getDocument($key);
            } catch (NotFoundException $e) {
                continue;
            }
        }

        if (!$documents) {
            return true;
        }

        $response = $this->index->deleteDocuments($documents);
        $this->index->flush(true);

        return $response->isOk();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elasticsearch-writer';
    }

    /**
     * @param array $dataSet
     *
     * @throws \Spryker\Zed\Collector\Business\Exporter\Exception\InvalidDataSetException
     *
     * @return array
     */
    protected function createDocuments(array $dataSet)
    {
        if ($this->hasIntegerKeys($dataSet)) {
            throw new InvalidDataSetException();
        }

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
     * Checks if the given array has any integer based (non-textual) keys
     *
     * @param array $array
     *
     * @return bool
     */
    protected function hasIntegerKeys(array $array)
    {
        return count(array_filter(array_keys($array), 'is_int')) > 0;
    }

}