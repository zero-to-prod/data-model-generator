<?php

namespace Zerotoprod\DataModelGenerator\Generator\Config;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;
use Zerotoprod\DataModelHelper\DataModelHelper;

class PropertyConfig
{
    use DataModel;

    /** Controls the readonly modifier for the property */
    public const readonly = 'readonly';

    /** Controls the visibility of the property */
    public const visibility = 'visibility';

    /**
     * A map of types and the resulting type.
     *
     * @see Type
     */
    public const types = 'types';

    /** Controls the visibility of comments */
    public const exclude_comments = 'exclude_comments';

    /** Controls the visibility of the property */
    public Visibility $visibility;

    /** Controls the readonly modifier for the property */
    #[Describe(['default' => false])]
    public bool $readonly;

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