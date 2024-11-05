<?php

namespace Tests\Acceptance\Config\Readonly\Readonly;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Config;

class ReadonlyTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
            Config::from(json_decode(file_get_contents(__DIR__.'/data_model.json'), true))
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                readonly class User
                {
                }
                PHP
        );
    }
}