<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Config
{
    use DataModel;

    /**
     * Config for model
     *
     * @see $model
     */
    public const model = 'model';

    /** Config for model */
    #[Describe(['nullable'])]
    public ?ModelConfig $model;
}