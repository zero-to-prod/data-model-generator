<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\DataModel;

class Type
{
    use DataModel;

    public const format = 'format';
    public const type = 'type';

    public PropertyFormat $format;

    public string $type;
}