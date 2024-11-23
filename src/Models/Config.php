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

    /**
     * The Fully Qualified Namespace for the DataModels
     *
     * @see $namespace
     */
    public const namespace = 'namespace';

    /**
     * Applies readonly to the class
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /**
     * Config for properties
     *
     * @see $properties
     */
    public const properties = 'properties';

    /**
     * Config for constants
     *
     * @see $constants
     */
    public const constants = 'constants';

    /**
     * Controls the visibility of comments
     *
     * @see $comments
     */
    public const comments = 'comments';

    /** The directory DataModels will be saved to. */
    #[Describe(['nullable'])]
    public ?string $directory;

    /** The Fully Qualified Namespace for the DataModels */
    #[Describe(['nullable'])]
    public ?string $namespace;

    /** Applies readonly to the class */
    #[Describe(['default' => false])]
    public bool $readonly;

    /** Config for properties */
    #[Describe(['nullable'])]
    public ?PropertyConfig $properties;

    /** Config for constants */
    public ConstantConfig $constants;

    /** Controls the visibility of comments */
    #[Describe(['default' => true])]
    public bool $comments;
}