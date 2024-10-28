<?php

namespace Zerotoprod\DataModelBuilder\FileSystem;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelBuilder\Helpers\DataModel;
use Zerotoprod\DataModelBuilder\PhpClass\PhpClass;

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