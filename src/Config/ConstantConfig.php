<?php

namespace Zerotoprod\DataModelGenerator\Config;

use Zerotoprod\DataModel\DataModel;
use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Model\Visibility;
use Zerotoprod\DataModelHelper\DataModelHelper;

class ConstantConfig
{
    use DataModel;

    /** The constant type.*/
    public const type = 'type';

    /** Controls the visibility of the constant. */
    public const visibility = 'visibility';

    /** Controls the visibility of comments */
    public const exclude_comments = 'exclude_comments';

    /** The constant type.*/
    public string $type;

    /** Controls the visibility of the constant. */
    public Visibility $visibility;

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $exclude_comments;
}