<?php

/** @var Binding $binding */
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Menu\ResourceMenu;

$binding->addMultiple([
    //admin
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [ResourceMenu::class, 'adminLinks']],
]);