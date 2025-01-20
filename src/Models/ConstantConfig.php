<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModel\Describe;

class ConstantConfig
{
    use DataModel;

    /**
     * Controls the visibility of the constant.
     *
     * @see $visibility
     */
    public const visibility = 'visibility';

    /**
     * Excludes the constant type.
     *
     * @see $type
     */
    public const type = 'type';

    /** Excludes the constant type.*/
    #[Describe(['default' => false])]
    public bool $type;

    /** Controls the visibility of the constant. */
    public Visibility $visibility;

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