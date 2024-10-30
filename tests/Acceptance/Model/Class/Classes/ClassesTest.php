<?php

namespace Acceptance\Model\Class\Classes;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Parser;

class ClassesTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generate(): void
    {
        Parser::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true)
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                }
                PHP
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Address.php',
            actualString: <<<PHP
                <?php
                class Address
                {
                }
                PHP
        );
    }
}