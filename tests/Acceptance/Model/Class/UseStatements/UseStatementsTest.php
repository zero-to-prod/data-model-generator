<?php

namespace Tests\Acceptance\Model\Class\UseStatements;

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
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                use \Zerotoprod\DataModel\DataModel;
                use \Zerotoprod\DataModel\Transformable;
                }
                PHP
        );
    }
}