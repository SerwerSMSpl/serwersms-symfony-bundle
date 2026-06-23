<?php

namespace SerwerSMS\SerwerSMSBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SerwerSMSExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // No credentials provided - client will register service manually
        if (empty($config['serwersms_token']) && empty($config['serwersms_username']) && empty($config['serwersms_password'])) {
            return;
        }

        if (!empty($config['serwersms_token'])) {
            $definition = new Definition(\SerwerSMS\SerwerSMSBundle\SerwerSMSToken::class, [
                $config['serwersms_token'],
                $config['serwersms_api_url'],
                $config['serwersms_timeout'],
            ]);
        } elseif (!empty($config['serwersms_username']) && !empty($config['serwersms_password'])) {
            $definition = new Definition(\SerwerSMS\SerwerSMSBundle\SerwerSMS::class, [
                $config['serwersms_username'],
                $config['serwersms_password'],
                $config['serwersms_api_url'],
                $config['serwersms_timeout'],
            ]);
        } else {
            throw new \InvalidArgumentException(
                'SerwerSMS bundle requires either "serwersms_token" or both "serwersms_username" and "serwersms_password" in serwer_sms configuration.'
            );
        }

        $definition->setPublic(true);
        $container->setDefinition('serwer_sms', $definition);
        $container->setAlias(\SerwerSMS\SerwerSMSBundle\SerwerSMSInterface::class, 'serwer_sms')->setPublic(true);
    }
}
