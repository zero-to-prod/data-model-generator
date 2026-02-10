<?php

namespace Tests\Acceptance\Overwrite\Model;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class OverwriteModelTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function model_can_be_overwritten(): void
    {
        $this->engineGenerate(__DIR__);
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                }
                PHP
        );
    }
}
