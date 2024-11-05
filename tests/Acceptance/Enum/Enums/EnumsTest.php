<?php

namespace Tests\Acceptance\Enum\Enums;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;

class EnumsTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            Components::from(json_decode(file_get_contents(__DIR__.'/models.json'), true)),
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Role.php',
            actualString: <<<PHP
                <?php
                enum Role
                {
                }
                PHP
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Permission.php',
            actualString: <<<PHP
                <?php
                enum Permission
                {
                }
                PHP
        );
    }
}