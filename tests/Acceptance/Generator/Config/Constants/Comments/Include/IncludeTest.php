<?php

namespace Acceptance\Generator\Config\Constants\Comments\Include;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Engine;

class IncludeTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
            json_decode(file_get_contents(__DIR__.'/data_model.json'), true)
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                /** comment */
                public const age = 'age';
                }
                PHP
        );
    }
}