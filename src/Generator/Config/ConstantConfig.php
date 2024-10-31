<?php

namespace Zerotoprod\DataModelGenerator\Generator\Config;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;

class ConstantConfig
{
    use DataModel;

    /** Excludes the constant type.*/
    public const exclude_type = 'exclude_type';

    /** Controls the visibility of the constant. */
    public const visibility = 'visibility';

    /** Controls the visibility of comments */
    public const exclude_comments = 'exclude_comments';

    /** Excludes the constant type.*/
    public bool $exclude_type;

    /** Controls the visibility of the constant. */
    public Visibility $visibility;

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $exclude_comments;
}