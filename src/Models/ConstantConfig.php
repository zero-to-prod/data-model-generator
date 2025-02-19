<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class ConstantConfig
{
    use DataModel;

    /**
     * Controls the visibility of the constant.
     *
     * @see  $visibility
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const visibility = 'visibility';

    /**
     * Excludes the constant type.
     *
     * @see  $type
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const type = 'type';

    /**
     * Excludes the constant type.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $type;

    /**
     * Controls the visibility of the constant.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public Visibility $visibility;

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