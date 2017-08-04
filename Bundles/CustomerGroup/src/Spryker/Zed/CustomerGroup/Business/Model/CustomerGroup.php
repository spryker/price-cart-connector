<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CustomerGroup\Business\Model;

use ArrayObject;
use Generated\Shared\Transfer\CustomerGroupToCustomerTransfer;
use Generated\Shared\Transfer\CustomerGroupTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\CustomerGroup\Persistence\SpyCustomerGroup;
use Orm\Zed\CustomerGroup\Persistence\SpyCustomerGroupToCustomer;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\CustomerGroup\Business\Exception\CustomerGroupNotFoundException;
use Spryker\Zed\CustomerGroup\Persistence\CustomerGroupQueryContainerInterface;

class CustomerGroup implements CustomerGroupInterface
{

    /**
     * @var \Spryker\Zed\CustomerGroup\Persistence\CustomerGroupQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @param \Spryker\Zed\CustomerGroup\Persistence\CustomerGroupQueryContainerInterface $queryContainer
     */
    public function __construct(CustomerGroupQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerGroupTransfer
     */
    public function get(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerGroupEntity = $this->getCustomerGroup($customerGroupTransfer);
        $customerGroupTransfer->fromArray($customerGroupEntity->toArray(), true);

        $customerGroupToCustomerCollection = $customerGroupEntity->getSpyCustomerGroupToCustomers();
        if ($customerGroupToCustomerCollection) {
            $customerGroupTransfer->setCustomers(
                $this->entityCollectionToTransferCollection($customerGroupToCustomerCollection)
            );
        }

        return $customerGroupTransfer;
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\CustomerGroup\Persistence\SpyCustomerGroupToCustomer[] $customerGroupToCustomerCollection
     *
     * @return \Generated\Shared\Transfer\CustomerGroupToCustomerTransfer[]
     */
    protected function entityCollectionToTransferCollection(ObjectCollection $customerGroupToCustomerCollection)
    {
        $customerGroups = new ArrayObject();

        foreach ($customerGroupToCustomerCollection as $customerGroupToCustomerEntity) {
            $customerGroupToCustomerTransfer = new CustomerGroupToCustomerTransfer();
            $customerGroupToCustomerTransfer->fromArray($customerGroupToCustomerEntity->toArray(), true);

            $customerGroups[] = $customerGroupToCustomerTransfer;
        }

        return $customerGroups;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerGroupTransfer
     */
    public function add(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerGroupEntity = new SpyCustomerGroup();
        $customerGroupEntity->fromArray($customerGroupTransfer->toArray());

        $this->queryContainer->getConnection()->beginTransaction();

        $customerGroupEntity->save();

        $this->saveCustomers($customerGroupTransfer, $customerGroupEntity);

        $this->queryContainer->getConnection()->commit();

        $customerGroupTransfer->setIdCustomerGroup($customerGroupEntity->getIdCustomerGroup());

        return $customerGroupTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @return void
     */
    public function update(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerGroupEntity = $this->getCustomerGroup($customerGroupTransfer);
        $customerGroupEntity->fromArray($customerGroupTransfer->toArray());

        $this->queryContainer->getConnection()->beginTransaction();
        $customerGroupEntity->save();

        $this->queryContainer
            ->queryCustomerGroupToCustomerByFkCustomerGroup($customerGroupEntity->getIdCustomerGroup())
            ->delete();

        $this->saveCustomers($customerGroupTransfer, $customerGroupEntity);

        $this->queryContainer->getConnection()->commit();
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     * @param \Orm\Zed\CustomerGroup\Persistence\SpyCustomerGroup $customerGroupEntity
     *
     * @return void
     */
    protected function saveCustomers(CustomerGroupTransfer $customerGroupTransfer, SpyCustomerGroup $customerGroupEntity)
    {
        foreach ($customerGroupTransfer->getCustomers() as $customerTransfer) {
            $customerGroupToCustomerEntity = new SpyCustomerGroupToCustomer();
            $customerGroupToCustomerEntity->setFkCustomerGroup($customerGroupEntity->getIdCustomerGroup());
            $customerGroupToCustomerEntity->setFkCustomer($customerTransfer->getFkCustomer());

            $customerGroupToCustomerEntity->save();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @return bool
     */
    public function delete(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerEntity = $this->getCustomerGroup($customerGroupTransfer);
        $customerEntity->delete();

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @throws \Spryker\Zed\CustomerGroup\Business\Exception\CustomerGroupNotFoundException
     *
     * @return \Orm\Zed\CustomerGroup\Persistence\SpyCustomerGroup
     */
    protected function getCustomerGroup(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerGroupTransfer->requireIdCustomerGroup();

        $customerEntity = $this->queryContainer->queryCustomerGroupById($customerGroupTransfer->getIdCustomerGroup())
                ->findOne();

        if (!$customerEntity) {
            throw new CustomerGroupNotFoundException(sprintf(
                'Customer group not found by ID `%s`',
                $customerGroupTransfer->getIdCustomerGroup()
            ));
        }

        return $customerEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerGroupTransfer $customerGroupTransfer
     *
     * @return void
     */
    public function removeCustomersFromGroup(CustomerGroupTransfer $customerGroupTransfer)
    {
        $customerGroupTransfer->requireIdCustomerGroup();
        $customerGroupTransfer->requireCustomers();

        foreach ($customerGroupTransfer->getCustomers() as $customer) {
            $customerEntity = $this->queryContainer
                ->queryCustomerGroupToCustomerByFkCustomerGroup($customerGroupTransfer->getIdCustomerGroup())
                ->filterByFkCustomer($customer->getFkCustomer())->findOne();

            if (!$customerEntity) {
                continue;
            }

            $customerEntity->delete();
        }
    }

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerGroupTransfer|null
     */
    public function findCustomerGroupByIdCustomer($idCustomer)
    {
        $customerGroupEntity = $this->queryContainer
            ->queryCustomerGroupByFkCustomer($idCustomer)
            ->findOne();

        if (!$customerGroupEntity) {
            return null;
        }

        $customerGroupTransfer = new CustomerGroupTransfer();
        $customerGroupTransfer->fromArray($customerGroupEntity->toArray(), true);

        return $customerGroupTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function removeCustomerFromAllGroups(CustomerTransfer $customerTransfer)
    {
        $customerTransfer->requireIdCustomer();

        $customerGroupTransfers = $this->findCustomerGroupsByIdCustomer($customerTransfer->getIdCustomer());

        foreach ($customerGroupTransfers as $customerGroupTransfer) {
            $customerGroupToCustomerTransfer = new CustomerGroupToCustomerTransfer();
            $customerGroupToCustomerTransfer->setFkCustomer($customerTransfer->getIdCustomer());

            $customerGroupTransfer->getCustomers()->append($customerGroupToCustomerTransfer);
            $this->removeCustomersFromGroup($customerGroupTransfer);
        }
    }

    /**
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CustomerGroupTransfer[]
     */
    protected function findCustomerGroupsByIdCustomer($idCustomer)
    {
        $customerGroupEntities = $this->queryContainer
            ->queryCustomerGroupByFkCustomer($idCustomer)
            ->find();

        $groups = [];

        foreach ($customerGroupEntities as $customerGroupEntity) {
            $customerGroupTransfer = new CustomerGroupTransfer();
            $customerGroupTransfer->fromArray($customerGroupEntity->toArray(), true);

            $groups[] = $customerGroupTransfer;
        }

        return $groups;
    }

}