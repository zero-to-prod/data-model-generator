<?php

namespace Acceptance\Config\Properties\Comments\Include;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Parser;

class IncludeTest extends TestCase
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
                namespace App\Models;
                class User
                {
                public \App\Int \$age;
                }
                PHP
        );
    }
}