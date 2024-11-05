<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Config
{
    use DataModel;

    /** The directory DataModels will be saved to. */
    public const directory = 'directory';

    /** The Fully Qualified Namespace for the DataModels */
    public const namespace = 'namespace';

    /** Applies readonly to the class */
    public const readonly = 'readonly';

    /** Config for properties */
    public const properties = 'properties';

    /** Config for constants */
    public const constants = 'constants';

    /** Controls the visibility of comments */
    public const comments = 'comments';

    /** The directory DataModels will be saved to. */
    #[Describe(['missing_as_null' => true])]
    public ?string $directory;

    /** The Fully Qualified Namespace for the DataModels */
    #[Describe(['missing_as_null' => true])]
    public ?string $namespace;

    /** Applies readonly to the class */
    #[Describe(['default' => false])]
    public bool $readonly;

    /** Config for properties */
    #[Describe(['missing_as_null' => true])]
    public ?PropertyConfig $properties;

    /** Config for constants */
    public ConstantConfig $constants;

    /** Controls the visibility of comments */
    #[Describe(['default' => true])]
    public bool $comments;

    public function types(): array
    {
        return isset($this->properties->types)
            ? array_combine(array_column($this->properties->types, Type::format), $this->properties->types)
            : [];
    }
}