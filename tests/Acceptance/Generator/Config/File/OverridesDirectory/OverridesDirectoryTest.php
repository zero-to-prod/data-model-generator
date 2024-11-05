<?php

namespace Acceptance\Generator\Config\File\OverridesDirectory;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Config\Config;
use Zerotoprod\DataModelGenerator\Generator\Engine;

class OverridesDirectoryTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
            Config::from(json_decode(file_get_contents(__DIR__.'/data_model.json'), true))
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/app/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                }
                PHP
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/app/Address.php',
            actualString: <<<PHP
                <?php
                class Address
                {
                }
                PHP
        );
    }
}