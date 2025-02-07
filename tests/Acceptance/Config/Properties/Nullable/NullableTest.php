<?php

namespace Tests\Acceptance\Config\Properties\Nullable;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class NullableTest extends TestCase
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
                public \\Date|null \$age = null;
                }
                PHP
        );
    }
}