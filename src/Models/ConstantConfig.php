<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModel\Describe;

class ConstantConfig
{
    use DataModel;

    /**
     * Excludes the constant type.
     *
     * @see $exclude_type
     */
    public const exclude_type = 'exclude_type';

    /**
     * Controls the visibility of the constant.
     *
     * @see $visibility
     */
    public const visibility = 'visibility';

    /**
     * Controls the visibility of comments
     *
     * @see $exclude_comments
     */
    public const exclude_comments = 'exclude_comments';

    /** Excludes the constant type.*/
    #[Describe(['default' => false])]
    public bool $exclude_type;

    /** Controls the visibility of the constant. */
    public Visibility $visibility;

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $exclude_comments;
}