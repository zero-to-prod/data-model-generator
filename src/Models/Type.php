<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Type
{
    use DataModel;

    /**
     * The property format
     *
     * @see  $format
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const format = 'format';

    /**
     * The property type
     *
     * @see  $type
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const type = 'type';

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public string $format;

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public string $type;
}