<?php

namespace Zerotoprod\DataModelGenerator\Generator;

use Zerotoprod\DataModelGenerator\Generator\Config\Config;
use Zerotoprod\DataModelGenerator\Generator\Config\Type;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Generator\Model\Constant;
use Zerotoprod\DataModelGenerator\Generator\Model\Enum;
use Zerotoprod\DataModelGenerator\Generator\Model\Model;
use Zerotoprod\DataModelGenerator\Generator\Model\Property;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;

class Engine
{
    public static function generate(array $FileSystem, ?Config $Config = null): void
    {
        foreach ($FileSystem[FileSystem::Models] ?? [] as $Model) {
            $types = $Config?->properties?->types
                ? array_combine(
                    array_column($Config?->properties->types, Type::format),
                    $Config?->properties->types
                )
                : [];

            Model::from([
                Model::namespace => $Config->namespace ?? $Model[Model::namespace] ?? null,
                Model::imports => $Model[Model::imports] ?? [],
                Model::filename => $Model[Model::filename] ?? null,
                Model::directory => $Config->directory ?? $Model[Model::directory] ?? null,
                Model::comment => $Model[Model::comment] ?? null,
                Model::readonly => $Config->readonly ?? $Model[Model::readonly] ?? null,
                Model::use_statements => $Model[Model::use_statements] ?? [],
                Model::properties => array_map(static function ($property) use ($Config, $types) {
                    $property[Property::type] = ($property[Property::format] ?? null) && isset($types[$property[Property::format]])
                        ? $types[$property[Property::format]][Property::type]
                        : $property[Property::type]
                        ?? null;

                    $property[Property::comment] = isset($Config->properties->exclude_comments)
                    && $Config->properties->exclude_comments
                        ? null
                        : $property[Property::comment] ?? null;

                    $property[Property::visibility] = $Config->properties->visibility
                        ?? $property[Property::visibility]
                        ?? Visibility::public->value;

                    $property[Property::readonly] = $Config->properties->readonly
                        ?? $property[Property::readonly]
                        ?? null;

                    return $property;
                }, $Model[Model::properties] ?? []),
                Model::constants => self::transformConstants($Config, $Model[Enum::constants] ?? []),
            ])->save();
        }

        foreach ($FileSystem[FileSystem::Enums] ?? [] as $Enum) {
            Enum::from([
                Enum::namespace => $Config->namespace ?? $Enum[Enum::namespace] ?? null,
                Enum::imports => $Enum[Enum::imports] ?? [],
                Enum::filename => $Enum[Enum::filename] ?? null,
                Enum::directory => $Config->directory ?? $Enum[Enum::directory] ?? null,
                Enum::comment => $Enum[Enum::comment] ?? null,
                Enum::backed_type => $Enum[Enum::backed_type] ?? null,
                Enum::use_statements => $Enum[Enum::use_statements] ?? [],
                Enum::constants => self::transformConstants($Config, $Enum[Enum::constants] ?? []),
                Enum::cases => $Enum[Enum::cases] ?? [],
            ])->save();
        }
    }

    private static function transformConstants(?Config $Config, array $Constants): array
    {
        return array_map(static function ($constant) use ($Config) {
            $constant[Constant::comment] = isset($Config->constants->exclude_comments)
            && $Config->constants->exclude_comments
                ? null
                : $constant[Constant::comment] ?? null;

            $constant[Constant::visibility] = $Config->constants->visibility
                ?? $constant[Constant::visibility]
                ?? null;

            $constant[Constant::type] = isset($Config->constants->exclude_type)
            && $Config->constants->exclude_type
                ? null
                : $constant[Constant::type] ?? null;

            return $constant;
        }, $Constants);
    }
}