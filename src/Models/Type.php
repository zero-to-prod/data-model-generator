<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Type
{
    use DataModel;

    /**
     * The property format
     *
     * @see $format
     */
    public const format = 'format';

    /**
     * The property type
     *
     * @see $type
     */
    public const type = 'type';

    public string $format;

    public string $type;
}