<?php

namespace Tests\Acceptance\Config\Readonly\NullableRequired;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class NullableRequiredTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        $this->engineGenerate(__DIR__);

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                readonly class User
                {
                #[\Zerotoprod\DataModel\Describe(['required' => true])]
                public string \$name;
                #[\Zerotoprod\DataModel\Describe(['nullable'])]
                public \Date|null \$age;
                }
                PHP
        );
    }
}
