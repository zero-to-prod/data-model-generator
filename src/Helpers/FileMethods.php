<?php

namespace Zerotoprod\DataModelBuilder\Helpers;

use RuntimeException;

trait FileMethods
{

    public function create(mixed $content = '', int $permissions = 0777, bool $overwrite = false): string
    {
        if (!$overwrite && file_exists($this->filepath)) {
            throw new RuntimeException("File already exists: $this->filepath");
        }

        if (!$this->ensureDirectoryExists($this->directory, $permissions)) {
            throw new RuntimeException("Failed to create directories: $this->directory");
        }

        if (file_put_contents($this->filepath, $content) === false) {
            throw new RuntimeException("Failed to write to file: $this->filepath");
        }

        return $this->filepath;
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