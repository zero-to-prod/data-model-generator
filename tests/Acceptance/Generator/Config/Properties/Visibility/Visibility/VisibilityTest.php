<?php

namespace Acceptance\Generator\Config\Properties\Visibility\Visibility;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Config\Config;
use Zerotoprod\DataModelGenerator\Generator\Engine;

class VisibilityTest extends TestCase
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
                class User
                {
                private \$age;
                }
                PHP
        );
    }
}