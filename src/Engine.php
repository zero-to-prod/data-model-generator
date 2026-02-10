<?php

namespace Zerotoprod\DataModelGenerator;

use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Config;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Enum;
use Zerotoprod\DataModelGenerator\Models\EnumCase;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;

/**
 * Builds DataModels from a Schema
 *
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Engine
{
    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public static function generate(Components $Components, Config $Config): void
    {
        if (!$Config->model) {
            return;
        }

        foreach ($Components->Models as $Model) {
            Model::from([
                Model::directory => $Config->model->directory ?? $Model->directory,
                Model::filename => $Model->filename,
                Model::namespace => $Config->model->namespace ?? $Model->namespace,
                Model::imports => [...$Config->model->imports, ...$Model->imports],
                Model::comment => $Config->model->comments ? $Model->comment : null,
                Model::readonly => $Config->model->readonly,
                Model::use_statements => [...$Config->model->use_statements, ...$Model->use_statements],
                Model::properties => $Config->model->properties
                    ? array_map(
                        static function (string $name, Property $Property) use ($Config) {
                            $isReadonly = $Config->model->readonly || $Config->model->properties->readonly;
                            $nullable = $Config->model->properties->nullable;

                            $types = array_values(array_intersect_key($Config->model->properties->types, array_flip($Property->types)))
                                ?: $Property->types;

                            $default = null;
                            $attributes = $Property->attributes;

                            if ($nullable) {
                                $describeParam = null;

                                if ($Property->required) {
                                    $describeParam = "'required' => true";
                                } elseif ($isReadonly) {
                                    $types[] = 'null';
                                    $describeParam = "'nullable' => true";
                                } else {
                                    $types[] = 'null';
                                    $default = 'null';
                                }

                                if ($describeParam !== null) {
                                    $merged = false;
                                    foreach ($attributes as $i => $attr) {
                                        if (str_contains($attr, '\\Zerotoprod\\DataModel\\Describe(')) {
                                            $pos = strrpos($attr, '])]');
                                            $attributes[$i] = substr($attr, 0, $pos).", $describeParam])]";
                                            $merged = true;
                                            break;
                                        }
                                    }
                                    if (!$merged) {
                                        $attributes[] = "#[\\Zerotoprod\\DataModel\\Describe([$describeParam])]";
                                    }
                                }
                            }

                            return [
                                Property::comment => $Config->model->properties->comments ? $Property->comment : null,
                                Property::visibility => $Config->model->properties->visibility ?? $Property->visibility,
                                Property::readonly => $Config->model->properties->readonly,
                                Property::types => $types,
                                Property::name => $name,
                                Property::attributes => $attributes,
                                Property::required => $Property->required,
                                Property::default => $default,
                            ];
                        },
                        array_keys($Model->properties),
                        array_values($Model->properties)
                    )
                    : [],
                Model::constants => $Config->model->constants ? self::transformConstants($Config, $Model->constants) : [],
            ])->save();
        }

        foreach ($Components->Enums as $Enum) {
            Enum::from([
                Enum::namespace => $Config->model->namespace ?? $Enum->namespace,
                Enum::imports => [...$Config->model->imports, ...$Enum->imports],
                Enum::comment => $Config->model->comments ? $Enum->comment : null,
                Enum::backed_type => $Enum->backed_type,
                Enum::use_statements => [...$Config->model->use_statements, ...$Enum->use_statements],
                Enum::constants => $Config->model->constants ? self::transformConstants($Config, $Enum->constants) : [],
                Enum::cases => array_map(
                    static fn(EnumCase $Case) => [
                        EnumCase::comment => $Case->comment,
                        EnumCase::name => $Case->name,
                        EnumCase::value => $Case->value,
                    ],
                    $Enum->cases
                ),
                Enum::filename => $Enum->filename,
                Enum::directory => $Config->model->directory ?? $Enum->directory,
            ])->save();
        }
    }

    private static function transformConstants(Config $Config, array $Constants): array
    {
        return array_map(
            static fn(string $name, Constant $Constant) => [
                Constant::comment => $Config->model->constants?->comments ? $Constant->comment : null,
                Constant::visibility => $Config->model->constants->visibility ?? $Constant->visibility,
                Constant::type => $Config->model->constants?->type ? $Constant->type : null,
                Constant::name => $name,
                Constant::value => $Constant->value,
            ],
            array_keys($Constants),
            array_values($Constants)
        );
    }
}