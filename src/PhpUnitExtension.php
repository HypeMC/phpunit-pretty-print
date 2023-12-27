<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use NunoMaduro\Collision\Adapters\Phpunit\Subscribers\EnsurePrinterIsRegisteredSubscriber;
use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration as PHPUnitConfiguration;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationFinishedSubscriber;
use RobinIngelbrecht\PHPUnitPrettyPrint\Subscriber\Application\ApplicationStartedSubscriber;

final class PhpUnitExtension implements Extension
{
    public function bootstrap(PHPUnitConfiguration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        if (!$this->isEnabled($parameters)) {
            return;
        }

        $configuration = Configuration::fromParameterCollection($parameters);

        $facade->replaceOutput();
        $facade->replaceProgressOutput();
        $facade->replaceResultOutput();

        $_SERVER['COLLISION_PRINTER'] = true;
        if ($configuration->useCompactMode()) {
            $_SERVER['COLLISION_PRINTER_COMPACT'] = true;
        }
        if ($configuration->displayProfiling()) {
            $_SERVER['COLLISION_PRINTER_PROFILE'] = true;
        }

        EnsurePrinterIsRegisteredSubscriber::register();

        $facade->registerSubscriber(new ApplicationStartedSubscriber());
        if (!$configuration->displayQuote()) {
            return;
        }
        $facade->registerSubscriber(new ApplicationFinishedSubscriber());
    }

    private function isEnabled(ParameterCollection $parameters): bool
    {
        return Configuration::isEnabled(
            'enable-pretty-print',
            'disable-pretty-print',
            $parameters,
            'enableByDefault',
            // Nothing has been set, assume the extension is enabled for backwards compatible reasons.
            true,
        );
    }
}
