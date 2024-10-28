<?php

namespace Tests\Unit\File;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\FileSystem\File;

class PathTest extends TestCase
{
    /** @link File::filepath() */
    #[Test] public function filepath(): void
    {
        $File = File::from([
            File::name => 'User.php',
        ]);

        $this->assertEquals('./User.php', $File->path);
    }

    /** @link File::filepath() */
    #[Test] public function set_directory(): void
    {
        $File = File::from([
            File::name => 'User.php',
            File::directory => '/app',
        ]);

        $this->assertEquals('/app/User.php', $File->path);
    }
}