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

    /** File details for the enum */
    public const File = 'File';

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
    public readonly ?string $backed_type;

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

    /** File details for the enum */
    #[Describe(['required' => true])]
    public readonly File $File;

    /**
     * Renders the enum
     *
     * @link PhpClassTest::render()
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
        return $this->File->create($this->render());
    }

    /**
     * Returns enum line
     *
     * @link PhpClassTest::classLine()
     * @link PhpClassTest::readonlyClassLine()
     */
    public function classLine(): string
    {
        return $this->backed_type
            ? "enum {$this->className()}: $this->backed_type"
            : "enum {$this->className()}";
    }

    /**
     * Get enum name
     *
     * @link PhpClassTest::classLine()
     * @link PhpClassTest::readonlyClassLine()
     */
    public function className(): string
    {
        return pathinfo($this->File->name, PATHINFO_FILENAME);
    }
}