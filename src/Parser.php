<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Model\Model;

class Parser
{
    public static function generate(FileSystem $FileSystem): void
    {
        foreach ($FileSystem->Models as $Model) {
            Model::from($Model)->save();
        }
    }
}