<?php

namespace Tests\Acceptance\Model\Properties\Name;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class NameTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
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