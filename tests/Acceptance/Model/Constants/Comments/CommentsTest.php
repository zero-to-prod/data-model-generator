<?php

namespace Tests\Acceptance\Model\Constants\Comments;

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
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                class User
                {
                /** Comment */
                public const age = 'age';
                }
                PHP
        );
    }
}