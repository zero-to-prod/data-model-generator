<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Config
{
    use DataModel;

    /**
     * The directory DataModels will be saved to.
     *
     * @see $directory
     */
    public const directory = 'directory';

    /** The directory DataModels will be saved to. */
    #[Describe(['nullable'])]
    public ?string $directory;

    /**
     * The Fully Qualified Namespace for the DataModels
     *
     * @see $namespace
     */
    public const namespace = 'namespace';

    /** The Fully Qualified Namespace for the DataModels */
    #[Describe(['nullable'])]
    public ?string $namespace;

    /**
     * Config for model
     *
     * @see $model
     */
    public const model = 'model';

    /** Config for model */
    #[Describe(['nullable'])]
    public ?ModelConfig $model;

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
     * Include constants
     *
     * @see $include_constants
     */
    public const include_constants = 'include_constants';

    /** Include constants */
    #[Describe(['default' => false])]
    public bool $include_constants;

    /**
     * Controls the visibility of comments
     *
     * @see $comments
     */
    public const comments = 'comments';

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $comments;
}