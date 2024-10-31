<?php

namespace Zerotoprod\DataModelGenerator\Generator;

use Zerotoprod\DataModelGenerator\Generator\Config\Config;
use Zerotoprod\DataModelGenerator\Generator\Config\ConstantConfig;
use Zerotoprod\DataModelGenerator\Generator\Config\PropertyConfig;
use Zerotoprod\DataModelGenerator\Generator\Config\Type;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\File;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Generator\Model\Constant;
use Zerotoprod\DataModelGenerator\Generator\Model\Model;
use Zerotoprod\DataModelGenerator\Generator\Model\Property;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;

class Engine
{
    public static function generate(array $FileSystem, array $Config = []): void
    {
        foreach ($FileSystem[FileSystem::Models] as $Model) {
            $types = isset($Config[Config::properties][PropertyConfig::types])
                ? array_combine(
                    array_column($Config[Config::properties][PropertyConfig::types], Type::format),
                    $Config[Config::properties][PropertyConfig::types]
                )
                : [];

            Model::from([
                Model::namespace => $Config[Config::namespace] ?? $Model[Model::namespace] ?? null,
                Model::imports => $Model[Model::imports] ?? [],
                Model::File => [
                    File::name => $Model[Model::File][File::name] ?? null,
                    File::directory => $Config[Config::directory] ?? $Model[Model::File][File::directory] ?? null,
                ],
                Model::comment => $Model[Model::comment] ?? null,
                Model::readonly => $Config[Config::readonly] ?? $Model[Model::readonly] ?? null,
                Model::use_statements => $Model[Model::use_statements] ?? [],
                Model::properties => array_map(static function ($property) use ($Config, $types) {
                    $property[Property::type] = ($property[Property::format] ?? null) && isset($types[$property[Property::format]])
                        ? $types[$property[Property::format]][Property::type]
                        : $property[Property::type]
                        ?? null;

                    $property[Property::comment] = isset($Config[Config::properties][PropertyConfig::exclude_comments])
                    && $Config[Config::properties][PropertyConfig::exclude_comments]
                        ? null
                        : $property[Property::comment]
                        ?? null;

                    $property[Property::visibility] = $Config[Config::properties][PropertyConfig::visibility] ??
                        $property[Property::visibility] ?? Visibility::public->value;

                    $property[Property::readonly] = $Config[Config::properties][PropertyConfig::readonly]
                        ?? $property[Property::readonly]
                        ?? null;

                    return $property;
                }, $Model[Model::properties] ?? []),
                Model::constants => array_map(static function ($constant) use ($Config) {
                    $constant[Constant::comment] = isset($Config[Config::constants][ConstantConfig::exclude_comments])
                    && $Config[Config::constants][ConstantConfig::exclude_comments]
                        ? null
                        : $constant[Constant::comment]
                        ?? null;

                    $constant[Constant::visibility] = $Config[Config::constants][ConstantConfig::visibility]
                        ?? $constant[Constant::visibility]
                        ?? null;

                    $constant[Constant::type] = isset($Config[Config::constants][ConstantConfig::exclude_type])
                    && $Config[Config::constants][ConstantConfig::exclude_type]
                        ? null
                        : $constant[Constant::type]
                        ?? null;

                    return $constant;
                }, $Model[Model::constants] ?? []),
            ])->save();
        }
    }

}