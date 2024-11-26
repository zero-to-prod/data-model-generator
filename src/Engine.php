<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Enum;
use Zerotoprod\DataModelGenerator\Models\EnumCase;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class Engine
{
    public static function generate(Components $Components): void
    {
        $Config = $Components->Config;
        foreach ($Components->Models as $Model) {
            Model::from([
                ...$Model->toArray(),
                Model::use_statements => array_merge($Config->model->use_statements ?? [], $Model->use_statements ?? []),
                Model::namespace => $Config->namespace ?? $Model->namespace,
                Model::directory => $Config->directory ?? $Model->directory,
                Model::readonly => $Config->readonly ?? $Model->readonly,
                Model::properties => array_combine(
                    array_keys($Model->properties),
                    array_map(
                        static function ($Property, $name) use ($Config) {
                            $result = $Property->toArray();
                            $result[Property::name] = $name;
                            $result[Property::type] = $Config->properties->types[$Property->type]->type ?? $Property->type;
                            $result[Property::comment] = $Config?->properties?->exclude_comments
                                ? null
                                : $Property->comment;
                            $result[Property::visibility] = $Config?->properties?->visibility
                                ?? $Property->visibility
                                ?? Visibility::public;
                            $result[Property::readonly] = $Config?->properties?->readonly
                                ?? $Property->readonly;

                            return $result;
                        },
                        $Model->properties,
                        array_keys($Model->properties)
                    )
                ),
                Model::constants => isset($Config->exclude_constants) && $Config->exclude_constants
                    ? []
                    : self::transformConstants($Config, $Model->constants),
            ])->save();
        }

        foreach ($Components->Enums as $Enum) {
            Enum::from([
                ...$Enum->toArray(),
                Enum::cases => array_map(
                    static fn($Case, $name) => [EnumCase::name => $name, ...$Case->toArray()],
                    $Enum->cases,
                    array_keys($Enum->cases)
                ),
                Enum::namespace => $Config->namespace ?? $Enum->namespace,
                Enum::directory => $Config->directory ?? $Enum->directory,
                Enum::constants => isset($Config->exclude_constants) && $Config->exclude_constants
                    ? []
                    : self::transformConstants($Config, $Enum->constants),
            ])->save();
        }
    }

    private static function transformConstants(?Config $Config, array $Constants): array
    {
        return array_combine(
            array_keys($Constants),
            array_map(
                static fn($Constant, $name) => [
                    ...$Constant->toArray(),
                    Constant::name => $name,
                    Constant::comment => $Config?->constants->exclude_comments
                        ? null
                        : $Constant->comment,
                    Constant::visibility => $Config?->constants->visibility ?? $Constant->visibility,
                    Constant::type => $Config?->constants->exclude_type
                        ? null
                        : $Constant->type,
                ],
                $Constants,
                array_keys($Constants)
            )
        );
    }
}