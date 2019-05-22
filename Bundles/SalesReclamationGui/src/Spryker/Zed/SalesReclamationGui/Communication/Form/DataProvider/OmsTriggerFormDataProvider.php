<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesReclamationGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ReclamationTransfer;
use Spryker\Zed\Gui\Communication\Form\DataProvider\AbstractOmsTriggerFormDataProvider;
use Spryker\Zed\Gui\Communication\Form\OmsTriggerForm;

class OmsTriggerFormDataProvider extends AbstractOmsTriggerFormDataProvider
{
    public const ROUTE_REDIRECT = '/sales-reclamation-gui/detail';
    public const QUERY_PARAM_ID_RECLAMATION = 'id-reclamation';

    /**
     * @param \Generated\Shared\Transfer\ReclamationTransfer $reclamationTransfer
     * @param string $event
     *
     * @return array
     */
    public function getOrderOmsTriggerFormOptions(ReclamationTransfer $reclamationTransfer, string $event): array
    {
        $redirectUrlParams = [
            static::QUERY_PARAM_ID_RECLAMATION => $reclamationTransfer->getIdSalesReclamation(),
        ];

        return [
            OmsTriggerForm::OPTION_OMS_ACTION => static::OMS_ACTION_ORDER_TRIGGER,
            OmsTriggerForm::OPTION_EVENT => $event,
            OmsTriggerForm::OPTION_SUBMIT_BUTTON_CLASS => static::SUBMIT_BUTTON_CLASS,
            OmsTriggerForm::OPTION_QUERY_PARAMS => [
                static::QUERY_PARAM_EVENT => $event,
                static::QUERY_PARAM_ID_SALES_ORDER => $reclamationTransfer->getOrder()->getIdSalesOrder(),
                static::QUERY_PARAM_REDIRECT => $this->createRedirectLink(static::ROUTE_REDIRECT, $redirectUrlParams),
            ],
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param string $event
     * @param int $idReclamation
     *
     * @return array
     */
    public function getOrderItemOmsTriggerFormOptions(ItemTransfer $itemTransfer, string $event, int $idReclamation): array
    {
        $redirectUrlParams = [
            static::QUERY_PARAM_ID_RECLAMATION => $idReclamation,
        ];

        return [
            OmsTriggerForm::OPTION_OMS_ACTION => static::OMS_ACTION_ITEM_TRIGGER,
            OmsTriggerForm::OPTION_EVENT => $event,
            OmsTriggerForm::OPTION_SUBMIT_BUTTON_CLASS => static::SUBMIT_BUTTON_CLASS,
            OmsTriggerForm::OPTION_QUERY_PARAMS => [
                static::QUERY_PARAM_EVENT => $event,
                static::QUERY_PARAM_ID_SALES_ORDER_ITEM => $itemTransfer->getIdSalesOrderItem(),
                static::QUERY_PARAM_REDIRECT => $this->createRedirectLink(static::ROUTE_REDIRECT, $redirectUrlParams),
            ],
        ];
    }
}
