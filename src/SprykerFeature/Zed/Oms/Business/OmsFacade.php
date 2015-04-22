<?php

namespace SprykerFeature\Zed\Oms\Business;

use SprykerFeature\Shared\Sales\Transfer\Order;
use SprykerEngine\Zed\Kernel\Business\AbstractFacade;
use SprykerFeature\Zed\Oms\Business\Model\Process;
use SprykerFeature\Zed\Oms\Business\Model\Process\Event;
use Propel\Runtime\Collection\ObjectCollection;
use SprykerFeature\Zed\Availability\Dependency\Facade\AvailabilityToOmsFacadeInterface;

/**
 * @method OmsDependencyContainer getDependencyContainer()
 */
class OmsFacade extends AbstractFacade implements AvailabilityToOmsFacadeInterface
{
    /**
     * @param $eventId
     * @param ObjectCollection $orderItems
     * @param array $logContext
     * @param array $data
     * @return array
     */
    public function triggerEvent($eventId, ObjectCollection $orderItems, array $logContext, array $data = array())
    {
        assert(is_string($eventId));
        $orderItemsArray = $this->getDependencyContainer()->createModelUtilCollectionToArrayTransformer()->transformCollectionToArray($orderItems);

        return $this->getDependencyContainer()->createModelOrderStateMachine($logContext)->triggerEvent($eventId, $orderItemsArray, $data);
    }

    /**
     * @param ObjectCollection $orderItems
     * @param array $logContext
     * @param array $data
     * @return array
     */
    public function triggerEventForNewItem(ObjectCollection $orderItems, array $logContext, array $data = array())
    {
        $orderItemsArray = $this->getDependencyContainer()->createModelUtilCollectionToArrayTransformer()->transformCollectionToArray($orderItems);

        return $this->getDependencyContainer()->createModelOrderStateMachine($logContext)->triggerEventForNewItem($orderItemsArray, $data);
    }

    /**
     * @return Process[]
     */
    public function getProcesses()
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getProcesses();
    }

    /**
     * @return array
     */
    public function getProcessList()
    {
        return $this->getDependencyContainer()
            ->createSettings()
            ->getActiveProcesses();
    }

    /**
     * @param string $eventId
     * @param Order  $orderItem
     * @param array  $logContext
     * @param array  $data
     * @return array
     */
    public function triggerEventForOneItem($eventId, $orderItem, array $logContext, array $data = array())
    {
        $orderItemsArray = array($orderItem);

        return $this->getDependencyContainer()
            ->createModelOrderStateMachine($logContext)
            ->triggerEvent($eventId, $orderItemsArray, $data);
    }

    /**
     * @param array $logContext
     * @return int
     */
    public function checkConditions(array $logContext)
    {
        return $this->getDependencyContainer()
            ->createModelOrderStateMachine($logContext)
            ->checkConditions();
    }

    /**
     * @param array $logContext
     * @return int
     */
    public function checkTimeouts(array $logContext)
    {
        return $this->getDependencyContainer()
            ->createModelOrderStateMachineTimeout($logContext)
            ->checkTimeouts();
    }

    /**
     * @param string $processName
     * @param bool   $highlightStatus
     * @param null   $format
     * @param null   $fontsize
     * @return bool
     */
    public function drawProcess($processName, $highlightStatus = null, $format = null, $fontsize = null)
    {
        $process = $this->getDependencyContainer()
            ->createModelBuilder()
            ->createProcess($processName);

        return $process->draw($highlightStatus, $format, $fontsize);
    }

    /**
     * TODO remove
     * @deprecated
     * @param string $processName
     * @return Process
     */
    public function getProcess($processName)
    {
        return $this->getDependencyContainer()
            ->createModelBuilder()
            ->createProcess($processName);
    }

    /**
     * TODO remove
     * @deprecated
     * @return Model\Dummy
     */
    public function getDummy()
    {
        return $this->getDependencyContainer()
            ->createModelDummy();
    }

    /**
     * @param \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order
     * @return Event[]
     */
    public function getGroupedManuallyExecutableEvents(\SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getGroupedManuallyExecutableEvents($order);
    }

    /**
     * @param \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order
     * @param string                                               $flag
     * @return \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrderItem[]
     */
    public function getItemsWithFlag(\SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order, $flag)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getItemsWithFlag($order, $flag);
    }

    /**
     * @param \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order
     * @param string                                               $flag
     * @return \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrderItem[]
     */
    public function getItemsWithoutFlag(\SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order, $flag)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getItemsWithoutFlag($order, $flag);
    }

    /**
     * @param \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order
     * @return PropelObjectCollection
     */
    public function getLogForOrder(\SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrder $order)
    {
        return $this->getDependencyContainer()
            ->createModelUtilTransitionLog()
            ->getLogForOrder($order);
    }

    /**
     * @param string $sku
     * @return \SprykerFeature_Zed_Library_Propel_ClearAllReferencesIterator
     */
    public function getReservedOrderItemsForSku($sku)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getReservedOrderItemsForSku($sku);
    }

    /**
     * @param string $sku
     * @return \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrderItem
     */
    public function countReservedOrderItemsForSku($sku)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->countReservedOrderItemsForSku($sku);
    }

    /**
     * @param string $statusName
     * @return \SprykerFeature\Zed\Oms\Persistence\Propel\SpyOmsOrderItemStatus
     */
    public function getStatusEntity($statusName)
    {
        return $this->getDependencyContainer()
            ->createModelPersistenceManager()
            ->getStatusEntity($statusName);
    }

    /**
     * @param string $processName
     * @return \SprykerFeature\Zed\Oms\Persistence\Propel\SpyOmsOrderProcess
     */
    public function getProcessEntity($processName)
    {
        return $this->getDependencyContainer()
            ->createModelPersistenceManager()
            ->getProcessEntity($processName);
    }

    /**
     * @return \SprykerFeature\Zed\Oms\Persistence\Propel\SpyOmsOrderItemStatus
     */
    public function getInitialStatusEntity()
    {
        return $this->getDependencyContainer()
            ->createModelPersistenceManager()
            ->getInitialStatusEntity();
    }

    /**
     * @param Order $transferOrder
     * @return string
     */
    public function selectProcess(Order $transferOrder)
    {
        return $this->getDependencyContainer()
            ->createSettings()
            ->selectProcess($transferOrder);
    }

    /**
     * @param \SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrderItem $orderItem
     * @return string
     */
    public function getStatusDisplayName(\SprykerFeature\Zed\Sales\Persistence\Propel\SpySalesOrderItem $orderItem)
    {
        return $this->getDependencyContainer()
            ->createModelFinder()
            ->getStatusDisplayName($orderItem);
    }

}
