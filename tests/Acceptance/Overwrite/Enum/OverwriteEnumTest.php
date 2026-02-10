<?php

namespace Tests\Acceptance\Overwrite\Enum;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class OverwriteEnumTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function enum_can_be_overwritten(): void
    {
        $this->engineGenerate(__DIR__);
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Status.php',
            actualString: <<<PHP
                <?php
                enum Status: string
                {
                case Active = 'active';
                }
                PHP
        );
    }
}
