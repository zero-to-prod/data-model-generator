<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class PropertyConfig
{
    use DataModel;

    /**
     * Controls the readonly modifier for the property
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /**
     * Controls the visibility of the property
     *
     * @see $visibility
     */
    public const visibility = 'visibility';

    /**
     * A map of types and the resulting type.
     *
     * @see $types
     */
    public const types = 'types';

    /**
     * Controls the visibility of comments
     *
     * @see $exclude_comments
     */
    public const exclude_comments = 'exclude_comments';

    /** Controls the visibility of the property */
    public Visibility $visibility;

    /** Controls the readonly modifier for the property */
    #[Describe(['default' => false])]
    public bool $readonly;

    /**
     * A map of types and the resulting type.
     *
     * @var array<string, Type> $types
     */
    #[Describe([
        'cast' => [self::class, 'resolveTypes'],
        'type' => Type::class,
    ])]
    public array $types;

    public static function resolveTypes($value): array
    {
        return array_combine(
            array_keys($value),
            array_map(
                static fn(string $format, array $type) => Type::from(array_merge([Type::format => $format], $type)),
                array_keys($value),
                $value
            )
        );
    }

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $exclude_comments;
}