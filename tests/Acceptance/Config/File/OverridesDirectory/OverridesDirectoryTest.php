<?php

namespace Acceptance\Config\File\OverridesDirectory;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Parser;

class OverridesDirectoryTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generate(): void
    {
        Parser::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
            json_decode(file_get_contents(__DIR__.'/data_model.json'), true)
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