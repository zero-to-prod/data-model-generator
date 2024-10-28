<?php

namespace Zerotoprod\DataModelGenerator\FileSystem;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\PhpClass\PhpClass;

class FileSystem
{
    use DataModel;

    /** A collection of Models */
    public const Models = 'Models';

    /**
     * A collection of models
     *
     * @var PhpClass[] $Models
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => PhpClass::class,
    ])]
    public array $Models;
}