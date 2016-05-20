<?php

namespace Shopware\Plugins\MoptPaymentPayone\Subscribers;

use Enlight\Event\SubscriberInterface;

/**
 * add clearing data to email
 */
class EMail implements SubscriberInterface
{

    /**
     * di container
     * 
     * @var \Shopware\Components\DependencyInjection\Container
     */
    private $container;

    /**
     * inject di container
     * 
     * @param \Shopware\Components\DependencyInjection\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * return array with all subsribed events
     * 
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Shopware_Modules_Order_SendMail_FilterVariables' => 'onSendMailFilterVariablesFilter'
        );
    }

    /**
     * add clearing data to email variables
     * 
     * @param \Shopware\Plugins\MoptPaymentPayone\Subscribers\Enlight_Hook_HookArgs $args
     * @return array
     */
    public function onSendMailFilterVariablesFilter(Enlight_Hook_HookArgs $args)
    {
        $variables = $args->getReturn();
        $session = Shopware()->Session();

        if ($session->moptClearingData) {
            $variables['additional']['moptPayoneClearingData'] = $session->moptClearingData;
            $args->setReturn($variables);
        }
    }

}
