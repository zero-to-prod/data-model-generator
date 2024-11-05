<?php

namespace Tests\Acceptance\Model\Properties\Attributes;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;

class AttributesTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(
            Components::from(json_decode(file_get_contents(__DIR__.'/models.json'), true)),
        );

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