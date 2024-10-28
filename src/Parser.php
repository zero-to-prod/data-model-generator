<?php

namespace Zerotoprod\DataModelBuilder;

use Zerotoprod\DataModelBuilder\FileSystem\FileSystem;
use Zerotoprod\DataModelBuilder\PhpClass\PhpClass;

class Parser
{
    public static function generate(FileSystem $FileSystem): void
    {
        foreach ($FileSystem->Models as $Model) {
            PhpClass::from($Model)->save();
        }
    }
}