<?php

namespace Tests\Acceptance\Enum\UseStatements;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class UseStatementsTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Role.php',
            actualString: <<<PHP
                <?php
                enum Role
                {
                use \Zerotoprod\DataModel\DataModel;
                use \Zerotoprod\DataModel\Transformable;
                }
                PHP
        );
    }
}