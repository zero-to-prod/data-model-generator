<?php

namespace Zerotoprod\DataModelGenerator\FileSystem;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Model\Model;

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