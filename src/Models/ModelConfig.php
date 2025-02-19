<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class ModelConfig
{
    use DataModel;

    /**
     * The directory of the file.
     *
     * @see  $directory
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const directory = 'directory';

    /**
     * The directory of the file.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public string $directory;

    /**
     * The Fully Qualified Namespace of the class
     *
     * @see  $namespace
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const namespace = 'namespace';

    /**
     * The Fully Qualified Namespace of the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $namespace;

    /**
     * Imports used in the class
     *
     * @see  $imports
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const imports = 'imports';

    /**
     * Imports used in the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /**
     * Applies readonly to the class
     *
     * @see  $readonly
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const readonly = 'readonly';

    /**
     * Applies readonly to the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $readonly;

    /**
     * Controls the visibility of comments
     *
     * @see  $comments
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comments = 'comments';

    /**
     * Controls the visibility of comments
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public bool $comments;

    /**
     * The use statement for the model.
     *
     * @see  $use_statement
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const use_statements = 'use_statements';

    /**
     * The use statement for the model.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public array $use_statements;

    /**
     * Config for constants
     *
     * @see  $constants
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const constants = 'constants';

    /**
     * Config for constants
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public ?ConstantConfig $constants;

    /**
     * Config for properties
     *
     * @see  $properties
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const properties = 'properties';

    /**
     * Config for properties
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public ?PropertyConfig $properties;
}