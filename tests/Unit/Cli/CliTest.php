<?php

namespace Tests\Unit\Cli;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CliTest extends TestCase
{
    private static string $bin = 'php bin/data-model-generator';

    #[Test] public function no_arguments_exits_without_warning(): void
    {
        exec(self::$bin.' 2>&1', $output, $exitCode);

        self::assertSame(0, $exitCode);
        self::assertEmpty(
            array_filter($output, static fn($line) => str_contains($line, 'Warning') || str_contains($line, 'Undefined')),
            'CLI emitted warnings when invoked without arguments'
        );
    }

    #[Test] public function generate_without_path_exits_without_error(): void
    {
        exec(self::$bin.' generate 2>&1', $output, $exitCode);

        self::assertSame(0, $exitCode);
        self::assertEmpty(
            array_filter($output, static fn($line) => str_contains($line, 'Warning') || str_contains($line, 'Fatal')),
            'CLI emitted errors when invoked with generate but no path'
        );
    }

    #[Test] public function generate_with_invalid_path_reports_failure(): void
    {
        exec(self::$bin.' generate /nonexistent/schema.json 2>&1', $output, $exitCode);

        self::assertSame(0, $exitCode);
        self::assertNotEmpty($output);
        self::assertStringContainsString('Failed to download', implode("\n", $output));
    }

    #[Test] public function generate_accepts_openapi_3_0_4(): void
    {
        $adapterInstalled = class_exists(\Zerotoprod\DataModelAdapterOpenapi30\OpenApi30::class);
        $schema = tempnam(sys_get_temp_dir(), 'openapi_');
        $config = './data-model.json';
        $configExisted = file_exists($config);

        file_put_contents($schema, json_encode([
            'openapi' => '3.0.4',
            'info' => ['title' => 'Test', 'version' => '1.0.0'],
            'paths' => (object)[],
            'components' => [
                'schemas' => [
                    'Item' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ]));

        if (!$configExisted) {
            file_put_contents($config, json_encode([
                'model' => [
                    'directory' => self::$test_dir,
                ],
            ]));
        }

        try {
            exec(self::$bin." generate $schema 2>&1", $output, $exitCode);
            $outputStr = implode("\n", $output);

            self::assertStringNotContainsString('Unsupported Schema', $outputStr, 'CLI should accept OpenAPI 3.0.4');

            if ($adapterInstalled) {
                self::assertSame(0, $exitCode, "CLI failed with output: $outputStr");
                self::assertFileExists(self::$test_dir.'/Item.php');
            } else {
                self::assertSame(1, $exitCode);
                self::assertStringContainsString('adapter not installed', $outputStr);
            }
        } finally {
            @unlink($schema);
            if (!$configExisted) {
                @unlink($config);
            }
        }
    }

    #[Test] public function generate_accepts_openapi_3_0_1(): void
    {
        $adapterInstalled = class_exists(\Zerotoprod\DataModelAdapterOpenapi30\OpenApi30::class);
        $schema = tempnam(sys_get_temp_dir(), 'openapi_');
        $config = './data-model.json';
        $configExisted = file_exists($config);

        file_put_contents($schema, json_encode([
            'openapi' => '3.0.1',
            'info' => ['title' => 'Test', 'version' => '1.0.0'],
            'paths' => (object)[],
            'components' => [
                'schemas' => [
                    'Thing' => [
                        'type' => 'object',
                        'properties' => [
                            'name' => ['type' => 'string'],
                        ],
                    ],
                ],
            ],
        ]));

        if (!$configExisted) {
            file_put_contents($config, json_encode([
                'model' => [
                    'directory' => self::$test_dir,
                ],
            ]));
        }

        try {
            exec(self::$bin." generate $schema 2>&1", $output, $exitCode);
            $outputStr = implode("\n", $output);

            self::assertStringNotContainsString('Unsupported Schema', $outputStr, 'CLI should accept OpenAPI 3.0.1');

            if ($adapterInstalled) {
                self::assertSame(0, $exitCode, "CLI failed with output: $outputStr");
                self::assertFileExists(self::$test_dir.'/Thing.php');
            } else {
                self::assertSame(1, $exitCode);
                self::assertStringContainsString('adapter not installed', $outputStr);
            }
        } finally {
            @unlink($schema);
            if (!$configExisted) {
                @unlink($config);
            }
        }
    }

    #[Test] public function init_creates_config_file(): void
    {
        $config = './data-model.json';
        $existed = file_exists($config);

        if ($existed) {
            rename($config, $config.'.bak');
        }

        try {
            exec(self::$bin.' init 2>&1', $output, $exitCode);

            self::assertSame(0, $exitCode);
            self::assertFileExists($config);
            self::assertStringContainsString('copied', implode("\n", $output));
        } finally {
            @unlink($config);
            if ($existed) {
                rename($config.'.bak', $config);
            }
        }
    }

    #[Test] public function init_does_not_overwrite_existing_config(): void
    {
        $config = './data-model.json';
        $existed = file_exists($config);
        $originalContent = $existed ? file_get_contents($config) : null;

        if (!$existed) {
            file_put_contents($config, '{"custom": true}');
        }

        try {
            exec(self::$bin.' init 2>&1', $output, $exitCode);

            self::assertSame(0, $exitCode);
            self::assertStringContainsString('already exists', implode("\n", $output));

            if (!$existed) {
                self::assertStringContainsString('{"custom": true}', file_get_contents($config));
            }
        } finally {
            if ($existed) {
                file_put_contents($config, $originalContent);
            } else {
                @unlink($config);
            }
        }
    }
}
