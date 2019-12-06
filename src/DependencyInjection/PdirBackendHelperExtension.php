<?php

/*
 * Backend Helper bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2019, pdir GmbH
 * @author     Mathias Arzberger <https://pdir.de>
 * @license    MIT
 */

namespace Pdir\BackendHelperBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PdirBackendHelperExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
