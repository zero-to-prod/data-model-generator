<?php

namespace Acceptance\Generator\Enum\Cases\Case;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Engine;

class CaseTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Role.php',
            actualString: <<<PHP
                <?php
                enum Role
                {
                case admin;
                }
                PHP
        );
    }
}