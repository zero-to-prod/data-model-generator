<?php

namespace Acceptance\BasicClass;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Parser;

class ParserTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generateClass(): void
    {
        Parser::generate(
            FileSystem::from(json_decode(file_get_contents(__DIR__ . '/models.json'), true))
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
    }
}