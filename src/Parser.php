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
use Zerotoprod\DataModelGenerator\Model\Visibility;

class Parser
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