<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class PropertyConfig
{
    use DataModel;

    /**
     * Controls the visibility of the property
     *
     * @see $visibility
     */
    public const visibility = 'visibility';

    /** Controls the visibility of the property */
    #[Describe(['nullable'])]
    public ?Visibility $visibility;

    /**
     * Controls the readonly modifier for the property
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /** Controls the readonly modifier for the property */
    #[Describe(['default' => false])]
    public bool $readonly;

    /**
     * A map of types and the resulting type.
     *
     * @see $types
     */
    public const types = 'types';

    /**
     * A map of types and the resulting type.
     *
     * @var array<string, string> $types
     */
    #[Describe(['default' => []])]
    public array $types;

    /**
     * Sets the property to null.
     *
     * @see $readonly
     */
    public const nullable = 'nullable';

    /** Sets the property to null. */
    #[Describe(['default' => false])]
    public bool $nullable;

    /**
     * Controls the visibility of comments
     *
     * @see $comments
     */
    public const comments = 'comments';

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $comments;
}