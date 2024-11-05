<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Enum;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Type;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class Engine
{
    public static function generate(Components $Components): void
    {
        $Config = $Components->Config;
        $types = isset($Config->properties->types)
            ? array_combine(
                array_column($Config->properties->types, Type::format),
                $Config->properties->types
            )
            : [];
        foreach ($Components->Models as $Model) {
            Model::from([
                ...$Model->toArray(),
                Model::namespace => $Config->namespace ?? $Model->namespace,
                Model::directory => $Config->directory ?? $Model->directory,
                Model::readonly => $Config->readonly ?? $Model->readonly,
                Model::properties => array_map(static function (Property $Property) use ($Config, $types) {
                    $result = $Property->toArray();
                    $result[Property::type] = $types[$result[Property::format]][Property::type] ?? $Property->type;
                    $result[Property::comment] = $Config?->properties?->exclude_comments
                        ? null
                        : $Property->comment;
                    $result[Property::visibility] = $Config?->properties?->visibility ?? $Property->visibility ?? Visibility::public->value;
                    $result[Property::readonly] = $Config?->properties?->readonly ?? $Property->readonly;

                    return $result;
                }, $Model->properties),
                Model::constants => self::transformConstants($Config, $Model->constants),
            ])->save();
        }

        foreach ($Components->Enums as $Enum) {
            Enum::from([
                ...$Enum->toArray(),
                Enum::cases => $Enum->cases,
                Enum::namespace => $Config->namespace ?? $Enum->namespace,
                Enum::directory => $Config->directory ?? $Enum->directory,
                Enum::constants => self::transformConstants($Config, $Enum->constants),
                Enum::backed_type => $Enum->backed_type,
            ])->save();
        }
    }

    private static function transformConstants(?Config $Config, array $Constants): array
    {
        return array_map(static function (Constant $Constant) use ($Config) {
            $result = $Constant->toArray();
            $result[Constant::comment] = $Config?->constants->exclude_comments ? null : $Constant->comment;
            $result[Constant::visibility] = $Config?->constants->visibility ?? $Constant->visibility;
            $result[Constant::type] = $Config?->constants->exclude_type ? null : $Constant->type;

            return $result;
        }, $Constants);
    }
}