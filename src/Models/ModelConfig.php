<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class ModelConfig
{
    use DataModel;

    /**
     * Config for properties
     *
     * @see $properties
     */
    public const properties = 'properties';

    /** Config for properties */
    #[Describe(['nullable'])]
    public ?PropertyConfig $properties;

    /**
     * Config for constants
     *
     * @see $constants
     */
    public const constants = 'constants';

    /** Config for constants */
    #[Describe(['nullable'])]
    public ?ConstantConfig $constants;

    /**
     * The use statement for the model.
     *
     * @see $use_statement
     */
    public const use_statements = 'use_statements';

    /** The use statement for the model. */
    #[Describe(['default' => []])]
    public array $use_statements;

    /**
     * Applies readonly to the class
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /** Applies readonly to the class */
    #[Describe(['default' => false])]
    public bool $readonly;
}