<?php

namespace Tests\Acceptance\Enum\OmitsConfigUseStatements;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class OmitsConfigUseStatementsTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function model_includes_config_imports_and_use_statements(): void
    {
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                use Zerotoprod\DataModel\DataModel;
                class User
                {
                use \Zerotoprod\DataModel\DataModel;
                public string \$name;
                }
                PHP
        );
    }

    /** @link Engine::generate() */
    #[Test] public function enum_omits_config_imports_and_use_statements(): void
    {
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/Role.php',
            actualString: <<<PHP
                <?php
                enum Role: string
                {
                case admin = 'admin';
                }
                PHP
        );
    }
}
