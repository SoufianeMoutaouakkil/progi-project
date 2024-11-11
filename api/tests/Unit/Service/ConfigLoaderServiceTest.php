<?php

namespace App\Tests\Unit\Service;

use App\Service\ConfigLoaderService;

class ConfigLoaderServiceTest extends \PHPUnit\Framework\TestCase
{

    private ConfigLoaderService $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new ConfigLoaderService([
            'fee' => [
                'common' => 100.0,
                'luxury' => 200.0,
            ],
        ]);
    }
    public function testGetFeeConfig(): void
    {
        $feeConfig = $this->config->getFeeConfig('fee');

        $this->assertNotNull($feeConfig);
        $this->assertArrayHasKey('common', $feeConfig);
        $this->assertArrayHasKey('luxury', $feeConfig);
        $this->assertArrayNotHasKey('invalid', $feeConfig);
    }

    public function testGetFeeConfigDefaultValue(): void
    {
        $notFoundConfig = $this->config->getFeeConfig('not_found');
        $this->assertNull($notFoundConfig);

        $defaultConfig = $this->config->getFeeConfig('not_found', ['default' => 300.0]);

        $this->assertNotNull($defaultConfig);
        $this->assertSame(300.0, $defaultConfig['default']);
    }
}
