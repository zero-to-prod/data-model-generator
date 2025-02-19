<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class PropertyConfig
{
    use DataModel;

    /**
     * Controls the visibility of the property
     *
     * @see  $visibility
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const visibility = 'visibility';

    /**
     * Controls the visibility of the property
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public ?Visibility $visibility;

    /**
     * Controls the readonly modifier for the property
     *
     * @see  $readonly
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const readonly = 'readonly';

    /**
     * Controls the readonly modifier for the property
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $readonly;

    /**
     * A map of types and the resulting type.
     *
     * @see  $types
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const types = 'types';

    /**
     * A map of types and the resulting type.
     *
     * @var array<string, string> $types
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public array $types;

    /**
     * Sets the property to null.
     *
     * @see  $readonly
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const nullable = 'nullable';

    /**
     * Sets the property to null.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $nullable;

    /**
     * Controls the visibility of comments
     *
     * @see  $comments
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comments = 'comments';

    /**
     * Controls the visibility of comments
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $comments;
}