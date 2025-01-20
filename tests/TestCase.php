<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;

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

    public function engineGenerate(string $dir = __DIR__): void
    {
        Engine::generate(
            Components::from([
                Components::Config => json_decode(file_get_contents($dir.'/data_model.json'), true),
                ...json_decode(file_get_contents($dir.'/models.json'), true),
            ]),
        );
    }
}