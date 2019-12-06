<?php

$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = [Pdir\BackendHelperBundle\EventListener\EditAllHelperListener::class, 'addScripts'];
