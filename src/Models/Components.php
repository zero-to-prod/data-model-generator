<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Components
{
    use DataModel;

    /**
     * A Config for the project
     *
     * @see $Config
     */
    public const Config = 'Config';

    /**
     * A collection of Models
     *
     * @see $Models
     */
    public const Models = 'Models';

    /**
     * A collection of Enums
     *
     * @see $Enums
     */
    public const Enums = 'Enums';

    /** A collection of Models */
    #[Describe(['nullable'])]
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
        'default' => []
    ])]
    public readonly array $Enums;
}