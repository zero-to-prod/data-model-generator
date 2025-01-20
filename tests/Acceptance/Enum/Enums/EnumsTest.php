<?php

namespace Tests\Acceptance\Enum\Enums;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class EnumsTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        $this->engineGenerate(__DIR__);

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