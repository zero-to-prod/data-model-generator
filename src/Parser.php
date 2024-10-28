<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Config\Config;
use Zerotoprod\DataModelGenerator\FileSystem\File;
use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Model\Model;

class Parser
{
    public static function generate(array $FileSystem, array $Config = []): void
    {
        foreach ($FileSystem[FileSystem::Models] as $Model) {
            Model::from([
                ...$Model,
                Model::namespace => $Model[Model::namespace] ?? $Config[Config::namespace],
                Model::File => [
                    ...$Model[Model::File],
                    File::directory => $Model[Model::File][File::directory] === null && isset($Config[Config::directory])
                        ? $Config[Config::directory]
                        : $Model[Model::File][File::directory],
                ],
            ])->save();
        }
    }
}