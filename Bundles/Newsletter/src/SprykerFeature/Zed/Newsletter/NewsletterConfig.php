<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerFeature\Zed\Newsletter;

use SprykerEngine\Zed\Kernel\AbstractBundleConfig;
use SprykerFeature\Shared\Newsletter\NewsletterConstants;
use SprykerFeature\Shared\Application\ApplicationConstants;

class NewsletterConfig extends AbstractBundleConfig
{

    /**
     * @param string $token
     *
     * @return string
     */
    public function getDoubleOptInApproveTokenUrl($token)
    {
        return $this->getHostYves() . '/newsletter/approve?token=' . $token;
    }

    /**
     * @return string
     */
    public function getHostYves()
    {
        return $this->get(ApplicationConstants::HOST_YVES);
    }

    /**
     * @return string|null
     */
    public function getFromEmailName()
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getFromEmailAddress()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getDoubleOptInConfirmationTemplateName()
    {
        return $this->get(NewsletterConstants::SHOP_MAIL_DOUBLE_OPT_IN_CONFIRMATION_TEMPLATE_NAME);
    }

    /**
     * @return string
     */
    public function getPasswordRestoreSubject()
    {
        return $this->get(NewsletterConstants::SHOP_MAIL_DOUBLE_OPT_IN_CONFIRMATION_SUBJECT);
    }

}
