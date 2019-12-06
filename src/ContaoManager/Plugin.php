<?php

/*
 * Backend Helper bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2019, pdir GmbH
 * @author     Mathias Arzberger <https://pdir.de>
 * @license    MIT
 */

namespace Pdir\BackendHelperBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Pdir\BackendHelperBundle\PdirBackendHelperBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(PdirBackendHelperBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
