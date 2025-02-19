<?php

namespace Zerotoprod\DataModelGenerator\Models;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
enum Visibility: string
{
    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    case public = 'public';
    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    case protected = 'protected';
    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    case private = 'private';
}