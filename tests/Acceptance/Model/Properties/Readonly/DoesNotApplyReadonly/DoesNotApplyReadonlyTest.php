<?php

namespace Acceptance\Model\Properties\Readonly\DoesNotApplyReadonly;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Parser;

class DoesNotApplyReadonlyTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generate(): void
    {
        Parser::generate(
            json_decode(file_get_contents(__DIR__.'/models.json'), true),
        );

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                namespace App\Models;
                class User
                {
                public \$age;
                }
                PHP
        );
    }
}