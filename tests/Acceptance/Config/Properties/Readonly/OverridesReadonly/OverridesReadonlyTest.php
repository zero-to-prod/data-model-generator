<?php

namespace Acceptance\Config\Properties\Readonly\OverridesReadonly;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Parser;

class OverridesReadonlyTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generate(): void
    {
        Parser::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
            json_decode(file_get_contents(__DIR__.'/data_model.json'), true)
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