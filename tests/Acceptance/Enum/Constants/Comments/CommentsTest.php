<?php

namespace Tests\Acceptance\Enum\Constants\Comments;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;

class CommentsTest extends TestCase
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
                /** Comment */
                public const admin = 'admin';
                }
                PHP
        );
    }
}