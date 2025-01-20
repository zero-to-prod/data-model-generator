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
    public static function generate(Components $Components, Config $Config): void
    {
        if (!$Config->model) {
            return;
        }

        foreach ($Components->Models as $Model) {
            $model = [
                Model::namespace => $Config->namespace ?? $Model->namespace,
                Model::imports => $Model->imports,
                Model::readonly => $Config->model->readonly,
                Model::comment => $Config->model->comments ? $Model->comment : null,
                Model::use_statements => [...$Config->model->use_statements, ...$Model->use_statements],
                Model::constants => $Config->model->constants
                    ? self::transformConstants($Config, $Model->constants)
                    : [],
                Model::filename => $Model->filename,
                Model::directory => $Config->directory ?? $Model->directory,
            ];

            if ($Config->model->properties) {
                $properties = [];
                foreach ($Model->properties as $name => $Property) {
                    $properties[$name] = [
                        Property::comment => $Config->model->properties->comments ? $Property->comment : null,
                        Property::visibility => $Config->model->properties->visibility ?? $Property->visibility ?? Visibility::public,
                        Property::readonly => $Config->model->properties->readonly,
                        Property::type => $Config->model->properties->types[$Property->type]->type ?? $Property->type,
                        Property::name => $name,
                        Property::attributes => $Property->attributes,
                    ];
                }
                $model[Model::properties] = $properties;
            } else {
                $model[Model::properties] = [];
            }

            Model::from($model)->save();
        }

        foreach ($Components->Enums as $Enum) {
            $cases = [];
            foreach ($Enum->cases as $Case) {
                $cases[] = [
                    EnumCase::comment => $Case->comment,
                    EnumCase::name => $Case->name,
                    EnumCase::value => $Case->value,
                ];
            }

            Enum::from([
                Enum::namespace => $Config->namespace ?? $Enum->namespace,
                Enum::imports => $Enum->imports,
                Enum::comment => $Config->model->comments ? $Enum->comment : null,
                Enum::backed_type => $Enum->backed_type,
                Enum::use_statements => $Enum->use_statements,
                Enum::constants => $Config->model->constants
                    ? self::transformConstants($Config, $Enum->constants)
                    : [],
                Enum::cases => $cases,
                Enum::filename => $Enum->filename,
                Enum::directory => $Config->directory ?? $Enum->directory,
            ])->save();
        }
    }

    private static function transformConstants(Config $Config, array $Constants): array
    {
        $result = [];
        foreach ($Constants as $name => $Constant) {
            $result[$name] = [
                Constant::comment => $Config->model->constants?->comments ? $Constant->comment : null,
                Constant::visibility => $Config->model->constants->visibility ?? $Constant->visibility,
                Constant::type => $Config->model->constants?->type ? $Constant->type : null,
                Constant::name => $name,
                Constant::value => $Constant->value,
            ];
        }
        return $result;
    }
}