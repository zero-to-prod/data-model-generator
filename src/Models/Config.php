<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Config
{
    use DataModel;

    /**
     * Config for model
     *
     * @see  $model
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const model = 'model';

    /**
     * Config for model
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public ?ModelConfig $model;
}