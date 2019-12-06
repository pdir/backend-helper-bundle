<?php

/*
 * Backend Helper bundle for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2019, pdir GmbH
 * @author     Mathias Arzberger <https://pdir.de>
 * @license    MIT
 */

namespace Pdir\BackendHelperBundle\Tests;

use Pdir\BackendHelperBundle\PdirBackendHelperBundle;
use PHPUnit\Framework\TestCase;

class PdirBackendHelperBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new PdirBackendHelperBundle();

        $this->assertInstanceOf('Pdir\BackendHelperBundle\PdirBackendHelperBundle', $bundle);
    }
}
