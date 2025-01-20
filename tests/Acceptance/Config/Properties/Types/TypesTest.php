<?php

namespace Tests\Acceptance\Config\Properties\Types;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class TypesTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                public \\Date \$age;
                }
                PHP
        );
    }
}