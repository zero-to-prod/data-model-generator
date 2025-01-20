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
        $Config = $Components->Config ?? Config::from();
        foreach ($Components->Models as $Model) {
            Model::from([
                Model::namespace => $Config->namespace ?? $Model->namespace,
                Model::imports => $Model->imports,
                Model::readonly => $Config->model->readonly ?? $Model->readonly,
                Model::comment => $Config->comments ? $Model->comment : null,
                Model::use_statements => array_merge($Config->model->use_statements ?? [], $Model->use_statements ?? []),
                Model::constants => $Config->include_constants ?? null
                    ? []
                    : self::transformConstants($Config, $Model->constants),
                Model::properties => array_combine(
                    array_keys($Model->properties),
                    array_map(
                        static function (Property $Property, $name) use ($Config) {
                            $result = [];
                            $result[Property::comment] = $Config?->properties?->exclude_comments
                                ? null
                                : $Property->comment;
                            $result[Property::visibility] = $Config?->properties?->visibility
                                ?? $Property->visibility
                                ?? Visibility::public;
                            $result[Property::readonly] = $Config?->properties?->readonly
                                ?? $Property->readonly;
                            $result[Property::type] = $Config->properties->types[$Property->type]->type ?? $Property->type;
                            $result[Property::name] = $name;
                            $result[Property::attributes] = $Property->attributes;

                            return $result;
                        },
                        $Model->properties,
                        array_keys($Model->properties),
                    ),
                ),
                Model::filename => $Model->filename,
                Model::directory => $Config->directory ?? $Model->directory,
            ])->save();
        }

        foreach ($Components->Enums as $Enum) {
            Enum::from([
                Enum::namespace => $Config->namespace ?? $Enum->namespace,
                Enum::imports => $Enum->imports,
                Enum::comment => $Config?->comments
                    ? $Enum->comment
                    : null,
                Enum::backed_type => $Enum->backed_type,
                Enum::use_statements => $Enum->use_statements,
                Enum::constants => $Config->include_constants ?? null
                    ? []
                    : self::transformConstants($Config, $Enum->constants),
                Enum::cases => array_map(
                    static fn(EnumCase $Case) => [
                        EnumCase::comment => $Case->comment,
                        EnumCase::name => $Case->name,
                        EnumCase::value => $Case->value,
                    ],
                    $Enum->cases,
                ),
                Enum::filename => $Enum->filename,
                Enum::directory => $Config->directory ?? $Enum->directory,
            ])->save();
        }
    }

    private static function transformConstants(?Config $Config, array $Constants): array
    {
        return array_combine(
            array_keys($Constants),
            array_map(
                static fn(Constant $Constant, $name) => [
                    Constant::comment => $Config?->constants->exclude_comments
                        ? null
                        : $Constant->comment,
                    Constant::visibility => $Config?->constants->visibility ?? $Constant->visibility,
                    Constant::type => $Config?->constants->exclude_type
                        ? null
                        : $Constant->type,
                    Constant::name => $name,
                    Constant::value => $Constant->value,
                ],
                $Constants,
                array_keys($Constants)
            )
        );
    }
}