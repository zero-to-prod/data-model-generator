<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Config\Config;
use Zerotoprod\DataModelGenerator\FileSystem\File;
use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Model\Model;
use Zerotoprod\DataModelGenerator\Model\Property;
use Zerotoprod\DataModelGenerator\Model\PropertyConfig;
use Zerotoprod\DataModelGenerator\Model\Type;

class Parser
{
    public static function generate(array $FileSystem, array $Config = []): void
    {
        foreach ($FileSystem[FileSystem::Models] as $Model) {
            $types = array_combine(
                array_column($Config[Config::properties][PropertyConfig::types] ?? [], Type::format),
                $Config[Config::properties][PropertyConfig::types] ?? []
            );

            Model::from([
                ...$Model,
                Model::namespace => $Model[Model::namespace] ?? $Config[Config::namespace] ?? null,
                Model::File => [
                    ...$Model[Model::File],
                    File::directory => $Model[Model::File][File::directory] ?? $Config[Config::directory] ?? null,
                ],
                Model::readonly => $Model[Model::readonly] ?? $Config[Config::readonly] ?? null,
                Model::properties => array_map(static function ($property) use ($types) {
                    $format = $property[Property::format] ?? null;
                    if ($format && isset($types[$format])) {
                        $property[Property::type] = $types[$format][Property::type];
                    }

                    return $property;
                }, $Model[Model::properties] ?? []),
            ])->save();
        }
    }
}