<?php

namespace Zerotoprod\DataModelGenerator\Generator\Model;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\File;
use Zerotoprod\DataModelGenerator\Generator\Helpers\ClassHelper;
use Zerotoprod\DataModelGenerator\Generator\Helpers\DataModel;

class Enum
{
    use DataModel;
    use ClassHelper;
    use File;

    /** The Fully Qualified Namespace of the enum */
    public const namespace = 'namespace';

    /** Imports used in the enum */
    public const imports = 'imports';

    /** Specifies the enum comment */
    public const comment = 'comment';

    /** The enum backing */
    public const backed_type = 'backed_type';

    /** Traits used in the enum */
    public const use_statements = 'use_statements';

    /** Constants used in the enum */
    public const constants = 'constants';

    /** The filename of the file. */
    public const filename = 'filename';

    /** The directory of the file. */
    public const directory = 'directory';

    /** The Fully Qualified Namespace of the enum */
    #[Describe(['missing_as_null' => true])]
    public readonly ?string $namespace;

    /** Imports used in the enum */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /** Specifies the enum comment */
    #[Describe(['missing_as_null' => true])]
    public readonly ?string $comment;

    /** The enum backing */
    #[Describe(['missing_as_null' => true])]
    public readonly ?BackedEnumType $backed_type;

    /** Traits used in the enum */
    #[Describe(['default' => []])]
    public readonly array $use_statements;

    /**
     * Constants used in the enum
     *
     * @var Constant[]
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Constant::class,
    ])]
    public readonly array $constants;

    /**
     * Renders the enum
     */
    public function render(): string
    {
        return implode(PHP_EOL, array_filter([
            '<?php',
            $this->namespaceLine(),
            $this->imports(),
            $this->comment,
            $this->classLine(),
            '{',
            $this->useStatements(),
            $this->constants(),
            '}'
        ]));
    }

    public function save(): string
    {
        return $this->create($this->render());
    }

    public function classLine(): string
    {
        return $this->backed_type
            ? "enum {$this->className()}: {$this->backed_type->value}"
            : "enum {$this->className()}";
    }

    public function className(): string
    {
        return pathinfo($this->filename, PATHINFO_FILENAME);
    }
}