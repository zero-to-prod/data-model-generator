<?php

namespace Zerotoprod\DataModelGenerator\Generator\FileSystem;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Generator\Model\Model;

class FileSystem
{
    use DataModel;

    /** A collection of Models */
    public const Models = 'Models';

    /**
     * A collection of models
     *
     * @var Model[] $Models
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Model::class,
    ])]
    public readonly array $Models;
}