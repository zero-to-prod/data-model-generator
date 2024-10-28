<?php

namespace Zerotoprod\DataModelGenerator\FileSystem;

use Tests\Unit\File\FilepathTest;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Helpers\FileMethods;

class File
{
    use DataModel;
    use FileMethods;

    /** The name of the file. */
    public const filename = 'filename';

    /** The directory of the file. */
    public const directory = 'directory';

    /** The name of the file. */
    #[Describe(['required' => true])]
    public string $filename;

    /** The directory of the file. */
    #[Describe(['default' => '.'])]
    public string $directory;

    #[Describe(['cast' => [self::class, 'filepath']])]
    public string $filepath;

    /** @link FilepathTest */
    private static function filepath($value, array $context): string
    {
        return rtrim($context[self::directory] ?? '.', DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR
            .$context[self::filename];
    }
}