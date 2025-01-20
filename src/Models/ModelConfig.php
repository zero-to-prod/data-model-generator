<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class ModelConfig
{
    use DataModel;

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