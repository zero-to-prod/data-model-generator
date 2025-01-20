<?php

namespace Tests\Acceptance\Model\Properties\Attributes;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class AttributesTest extends TestCase
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
                #[\Zerotoprod\DataModel\Describe(['default' => 'a'])]
                #[\Zerotoprod\DataModel\Describe(['default' => 'a'])]
                public \$age;
                }
                PHP
        );
    }
}