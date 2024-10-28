<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\PhpClass\PhpClass;

class Parser
{
    public static function generate(FileSystem $FileSystem): void
    {
        foreach ($FileSystem->Models as $Model) {
            PhpClass::from($Model)->save();
        }
    }
}