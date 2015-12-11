<?php

use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Peridot\Plugin\Watcher\WatcherPlugin;

return function (EventEmitterInterface $eventEmitter) {
    (new WatcherPlugin($eventEmitter))->track(__DIR__ . '/src');

    $eventEmitter->on('peridot.start', function (Environment $environment) {
        $environment->getDefinition()->getArgument('path')->setDefault('specs');
    });
};
