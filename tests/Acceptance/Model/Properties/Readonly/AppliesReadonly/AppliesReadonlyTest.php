<?php

namespace Tests\Acceptance\Model\Properties\Readonly\AppliesReadonly;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;

class AppliesReadonlyTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            Components::from(json_decode(file_get_contents(__DIR__.'/models.json'), true)),
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                namespace App\Models;
                class User
                {
                public readonly \$age;
                }
                PHP
        );
    }
}