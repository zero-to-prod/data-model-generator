<?php

namespace Zerotoprod\DataModelGenerator\Generator\FileSystem;

use RuntimeException;
use Zerotoprod\DataModel\Describe;

trait File
{
    /** The filename of the file. */
    #[Describe(['required' => true])]
    public readonly string $filename;

    /** The directory of the file. */
    #[Describe(['default' => '.'])]
    public readonly string $directory;

    #[Describe(['cast' => [self::class, 'path']])]
    public readonly string $path;

    /** @link FilepathTest */
    private static function path($value, array $context): string
    {
        return rtrim($context[self::directory] ?? '.', DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR
            .$context[self::filename];

    }
    public function create(mixed $content = '', int $permissions = 0777, bool $overwrite = false): string
    {
        if (!$overwrite && file_exists($this->path)) {
            throw new RuntimeException("File already exists: $this->path");
        }

        if (!$this->ensureDirectoryExists($this->directory, $permissions)) {
            throw new RuntimeException("Failed to create directories: $this->directory");
        }

        if (file_put_contents($this->path, $content) === false) {
            throw new RuntimeException("Failed to write to file: $this->path");
        }

        return $this->path;
    }

    /**
     * Ensure a directory exists.
     */
    public function ensureDirectoryExists(string $path, int $mode = 0755, bool $recursive = true): bool
    {
        if (!is_dir($path)) {
            $this->makeDirectory($path, $mode, $recursive);
        }

        return true;
    }

    /**
     * Create a directory.
     */
    public function makeDirectory(string $path, int $mode = 0755, bool $recursive = false, bool $force = false): bool
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }

        return mkdir($path, $mode, $recursive);
    }
}