<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Components
{
    use DataModel;

    /**
     * A collection of Models
     *
     * @see  $Models
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const Models = 'Models';

    /**
     * A collection of Models
     *
     * @var Model[] $Models
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Model::class,
        'default' => []
    ])]
    public readonly array $Models;

    /**
     * A collection of Enums
     *
     * @see  $Enums
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const Enums = 'Enums';

    /**
     * A collection of Enums
     *
     * @var Enum[] $Enums
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Enum::class,
        'default' => []
    ])]
    public readonly array $Enums;
}