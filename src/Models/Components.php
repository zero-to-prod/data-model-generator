<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Components
{
    use DataModel;

    /** A Config for the project */
    public const Config = 'Config';

    /** A collection of Models */
    public const Models = 'Models';

    /** A collection of Enums */
    public const Enums = 'Enums';

    /** A collection of Models */
    #[Describe(['missing_as_null' => true])]
    public ?Config $Config;

    /**
     * A collection of Models
     *
     * @var Model[] $Models
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Model::class,
    ])]
    public readonly array $Models;

    /**
     * A collection of Enums
     *
     * @var Enum[] $Enums
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Enum::class,
    ])]
    public readonly array $Enums;
}