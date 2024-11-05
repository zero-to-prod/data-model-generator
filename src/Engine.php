<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Models\Config;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Enum;
use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Type;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class Engine
{
    public static function generate(Components $Components): void
    {
        $Config = $Components->Config;
        foreach ($Components->Models as $Model) {
            $types = $Config?->properties?->types
                ? array_combine(
                    array_column($Config?->properties->types, Type::format),
                    $Config?->properties->types
                )
                : [];

            Model::from([
                Model::namespace => $Config->namespace ?? $Model->namespace ?? null,
                Model::imports => $Model->imports ?? [],
                Model::filename => $Model->filename ?? null,
                Model::directory => $Config->directory ?? $Model->directory ?? null,
                Model::comment => $Model->comment ?? null,
                Model::readonly => $Config->readonly ?? $Model->readonly ?? null,
                Model::use_statements => $Model->use_statements ?? [],
                Model::properties => array_map(static function ($property) use ($Config, $types) {
                    $property = $property->toArray();
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
                }, $Model->properties ?? []),
                Model::constants => self::transformConstants($Config, $Model->constants ?? []),
            ])->save();
        }

        foreach ($Components->Enums ?? [] as $Enum) {
            Enum::from([
                Enum::namespace => $Config->namespace ?? $Enum->namespace ?? null,
                Enum::imports => $Enum->imports ?? [],
                Enum::filename => $Enum->filename ?? null,
                Enum::directory => $Config->directory ?? $Enum->directory ?? null,
                Enum::comment => $Enum->comment ?? null,
                Enum::backed_type => $Enum->backed_type ?? null,
                Enum::use_statements => $Enum->use_statements ?? [],
                Enum::constants => self::transformConstants($Config, $Enum->constants ?? []),
                Enum::cases => $Enum->cases ?? [],
            ])->save();
        }
    }

    private static function transformConstants(?Config $Config, array $Constants): array
    {
        return array_map(static function ($constant) use ($Config) {
            $constant = $constant->toArray();
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