<?php

namespace RobinIngelbrecht\PHPUnitPrettyPrint;

use PHPUnit\Runner\Extension\ParameterCollection;

class Configuration
{
    private function __construct(
        private readonly bool $displayProfiling,
        private readonly bool $displayQuote,
        private readonly bool $useCompactMode,
    ) {
    }

    public function displayProfiling(): bool
    {
        return $this->displayProfiling;
    }

    public function displayQuote(): bool
    {
        return $this->displayQuote;
    }

    public function useCompactMode(): bool
    {
        return $this->useCompactMode;
    }

    public static function fromParameterCollection(ParameterCollection $parameters): self
    {
        $useProfiling = self::isEnabled('profiling', 'no-profiling', $parameters, 'displayProfiling');
        $useCompactMode = self::isEnabled('compact', 'no-compact', $parameters, 'useCompactMode');
        $displayQuote = self::isEnabled('display-quote', 'no-display-quote', $parameters, 'displayQuote');

        return new self(
            $useProfiling,
            $displayQuote,
            $useCompactMode,
        );
    }

    public static function isEnabled(
        string $enabledOption,
        string $disabledOption,
        ParameterCollection $parameters,
        string $parameter,
        bool $default = false,
    ): bool {
        if (in_array('--'.$enabledOption, $_SERVER['argv'], true)) {
            return true;
        }
        if (in_array('--'.$disabledOption, $_SERVER['argv'], true)) {
            return false;
        }

        if ($parameters->has($parameter)) {
            return !self::isFalsy($parameters->get($parameter));
        }

        return $default;
    }

    public static function isFalsy(mixed $value): bool
    {
        if (is_bool($value)) {
            return !$value;
        }
        if ('true' === $value) {
            return false;
        }
        if ('false' === $value) {
            return true;
        }
        if (is_int($value)) {
            return !$value;
        }

        return true;
    }
}
