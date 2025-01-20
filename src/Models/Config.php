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
     * Controls the visibility of comments
     *
     * @see $comments
     */
    public const comments = 'comments';

    /** Controls the visibility of comments */
    #[Describe(['default' => false])]
    public bool $comments;
}