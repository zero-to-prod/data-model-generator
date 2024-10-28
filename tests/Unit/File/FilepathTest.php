<?php

namespace Tests\Unit\File;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelBuilder\FileSystem\File;

class FilepathTest extends TestCase
{
    /** @link File::filepath() */
    #[Test] public function filepath(): void
    {
        $File = File::from([
            File::filename => 'User.php',
        ]);

        $this->assertEquals('./User.php', $File->filepath);
    }

    /** @link File::filepath() */
    #[Test] public function set_directory(): void
    {
        $File = File::from([
            File::filename => 'User.php',
            File::directory => '/app',
        ]);

        $this->assertEquals('/app/User.php', $File->filepath);
    }
}