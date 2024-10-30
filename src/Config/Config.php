<?php

namespace Zerotoprod\DataModelGenerator\Config;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

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
    public const properties = 'properties';

    /** Controls the visibility of comments */
    public const comments = 'comments';

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
     */
    public PropertyConfig $properties;

    /** Controls the visibility of comments */
    #[Describe(['default' => true])]
    public bool $comments;
}