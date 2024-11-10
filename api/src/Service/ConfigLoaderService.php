<?php

namespace App\Service;

class ConfigLoaderService
{
    private array $feesConfig;
    public function __construct(array $feesConfig)
    {
        $this->feesConfig = $feesConfig;
    }
    public function getFeeConfig(string $key, $default = null): ?array
    {
        return $this->feesConfig[$key] ?? $default;
    }
}
