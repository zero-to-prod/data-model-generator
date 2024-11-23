<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\DataModel;

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

    public PropertyFormat $format;

    public string $type;
}