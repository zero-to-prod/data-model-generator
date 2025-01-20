<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;

abstract class TestCase extends BaseTestCase
{
    public static string $test_dir = './tests/generated';

    protected function setUp(): void
    {
        parent::setUp();

        exec(
            (stripos(PHP_OS_FAMILY, 'WIN') === 0
                ? 'rmdir /S /Q '
                : 'rm -rf ').self::$test_dir
        );
    }

    public function engineGenerate(string $dir): void
    {
        Engine::generate(
            Components::from(json_decode(file_get_contents($dir.'/models.json'), true)),
            Config::from(json_decode(file_get_contents($dir.'/data_model.json'), true)),
        );
    }
}