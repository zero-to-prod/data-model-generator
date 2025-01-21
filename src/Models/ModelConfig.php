<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class ModelConfig
{
    use DataModel;

    /**
     * The directory of the file.
     *
     * @see $directory
     */
    public const directory = 'directory';

    /**
     * The directory of the file.
     */
    #[Describe(['nullable'])]
    public string $directory;

    /**
     * The Fully Qualified Namespace of the class
     *
     * @see $namespace
     */
    public const namespace = 'namespace';

    /** The Fully Qualified Namespace of the class */
    #[Describe(['nullable'])]
    public readonly ?string $namespace;

    /**
     * Imports used in the class
     *
     * @see $imports
     */
    public const imports = 'imports';

    /** Imports used in the class */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /**
     * Applies readonly to the class
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /** Applies readonly to the class */
    #[Describe(['default' => false])]
    public bool $readonly;

    /**
     * Controls the visibility of comments
     *
     * @see $comments
     */
    public const comments = 'comments';

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $comments;

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
     * Config for constants
     *
     * @see $constants
     */
    public const constants = 'constants';

    /** Config for constants */
    #[Describe(['nullable'])]
    public ?ConstantConfig $constants;

    /**
     * Config for properties
     *
     * @see $properties
     */
    public const properties = 'properties';

    /** Config for properties */
    #[Describe(['nullable'])]
    public ?PropertyConfig $properties;
}