<?php

namespace Tests\Acceptance\Config\Properties\Readonly\OverridesReadonly;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;

class OverridesReadonlyTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            Components::from([
                Components::Config => json_decode(file_get_contents(__DIR__.'/data_model.json'), true),
                ...json_decode(file_get_contents(__DIR__.'/models.json'), true),
            ]),
        );
        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                public \$age;
                }
                PHP
        );
    }
}