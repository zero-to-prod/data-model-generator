<?php

namespace Zerotoprod\DataModelGenerator\Config;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Model\Type;
use Zerotoprod\DataModelHelper\DataModelHelper;

class Config
{
    use DataModel;

    /** The directory DataModels will be saved to. */
    public const directory = 'directory';

    /** The Fully Qualified Namespace for the DataModels */
    public const namespace = 'namespace';

    /** Creates readonly properties or classes. */
    public const readonly = 'readonly';

    /** A map of types and the resulting type. */
    public const types = 'types';

    /** The directory DataModels will be saved to. */
    #[Describe(['default' => '.'])]
    public string $directory;

    /** The Fully Qualified Namespace for the DataModels */
    #[Describe(['missing_as_null' => true])]
    public ?string $namespace;

    /** Creates readonly properties or classes. */
    #[Describe(['default' => true])]
    public bool $readonly;

    /**
     * A map of types and the resulting type.
     *
     * @var Type[] $types
     */
    #[Describe([
        'cast' => [DataModelHelper::class, 'mapOf'],
        'type' => Type::class
    ])]
    public array $types;
}