<?php

namespace Zerotoprod\DataModelGenerator\Model;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelHelper\DataModelHelper;

class PropertyConfig
{
    use DataModel;

    public const types = 'types';

    /**
     * A map of types and the resulting type.
     *
     * @var Type[] $types
     */
    #[Describe([
        'cast' => [DataModelHelper::class, 'mapOf'],
        'type' => Type::class
    ])]
    public array $types;
}