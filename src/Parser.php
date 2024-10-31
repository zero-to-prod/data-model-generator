<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Config\Config;
use Zerotoprod\DataModelGenerator\Config\ConstantConfig;
use Zerotoprod\DataModelGenerator\Config\PropertyConfig;
use Zerotoprod\DataModelGenerator\Config\Type;
use Zerotoprod\DataModelGenerator\FileSystem\File;
use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Model\Constant;
use Zerotoprod\DataModelGenerator\Model\Model;
use Zerotoprod\DataModelGenerator\Model\Property;

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
                Model::namespace => $Config[Config::namespace] ?? $Model[Model::namespace] ?? null,
                Model::File => [
                    ...$Model[Model::File],
                    File::directory => $Config[Config::directory] ?? $Model[Model::File][File::directory] ?? null,
                ],
                Model::readonly => $Config[Config::readonly] ?? $Model[Model::readonly] ?? null,
                Model::properties => array_map(static function ($property) use ($Config, $types) {
                    $property[Property::type] = ($property[Property::format] ?? null) && isset($types[$property[Property::format]])
                        ? $types[$property[Property::format]][Property::type]
                        : $property[Property::type] ?? null;

                    if (isset($Config[Config::properties][PropertyConfig::exclude_comments])
                        && $Config[Config::properties][PropertyConfig::exclude_comments]
                    ) {
                        $property[Property::comment] = null;
                    }

                    if (isset($Config[Config::properties][PropertyConfig::visibility])) {
                        $property[Property::visibility] = $Config[Config::properties][PropertyConfig::visibility];
                    }

                    if (isset($Config[Config::properties][PropertyConfig::readonly])) {
                        $property[Property::readonly] = $Config[Config::properties][PropertyConfig::readonly];
                    }

                    return $property;
                }, $Model[Model::properties] ?? []),
                Model::constants => array_map(static function ($constant) use ($Config) {
                    if (isset($Config[Config::constants][ConstantConfig::exclude_comments])
                        && $Config[Config::constants][ConstantConfig::exclude_comments]
                    ) {
                        $constant[Constant::comment] = null;
                    }

                    if (isset($Config[Config::constants][ConstantConfig::visibility])) {
                        $constant[Constant::visibility] = $Config[Config::constants][ConstantConfig::visibility];
                    }

                    if (isset($Config[Config::constants][ConstantConfig::exclude_type])
                        && $Config[Config::constants][ConstantConfig::exclude_type]
                    ) {
                        $constant[Constant::type] = null;
                    }

                    return $constant;
                }, $Model[Model::constants] ?? []),
            ])->save();
        }
    }
}