<?php

namespace Zerotoprod\DataModelGenerator\Config;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelHelper\DataModelHelper;

class PropertyConfig
{
    use DataModel;

    /**
     * A map of types and the resulting type.
     *
     * @see Type
     */
    public const types = 'types';

    /** Controls the visibility of comments */
    public const exclude_comments = 'exclude_comments';

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

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $exclude_comments;
}