<?php

namespace Zerotoprod\DataModelGenerator\Generator\Model;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\File;
use Zerotoprod\DataModelGenerator\Generator\Helpers\ClassHelper;
use Zerotoprod\DataModelGenerator\Generator\Helpers\DataModel;

class Model
{
    use DataModel;
    use ClassHelper;

    /** The Fully Qualified Namespace of the class */
    public const namespace = 'namespace';

    /** Imports used in the class */
    public const imports = 'imports';

    /** Specifies a class */
    public const readonly = 'readonly';

    /** Specifies the class comment */
    public const comment = 'comment';

    /** Traits used in the class */
    public const use_statements = 'use_statements';

    /** Constants used in the class */
    public const constants = 'constants';

    /** Properties used in the class */
    public const properties = 'properties';

    /** File details for the PhpClass */
    public const File = 'File';

    /** The Fully Qualified Namespace of the class*/
    #[Describe(['missing_as_null' => true])]
    public readonly ?string $namespace;

    /** Imports used in the class */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /** Specifies a class*/
    #[Describe(['default' => false])]
    public readonly bool $readonly;

    /** Specifies the class comment */
    #[Describe(['missing_as_null' => true])]
    public readonly ?string $comment;

    /** Traits used in the class */
    #[Describe(['default' => []])]
    public readonly array $use_statements;

    /**
     * Constants used in the class
     *
     * @var Constant[]
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Constant::class,
    ])]
    public readonly array $constants;

    /**
     * Properties used in the class
     *
     * @var Property[]
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Property::class,
    ])]
    public readonly array $properties;

    /** File details for the PhpClass */
    #[Describe(['required' => true])]
    public readonly File $File;

    /**
     * Renders the class
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
            $this->properties(),
            '}'
        ]));
    }

    public function save(): string
    {
        return $this->File->create($this->render());
    }

    /**
     * Returns class line
     *
     * @link PhpClassTest::classLine()
     * @link PhpClassTest::readonlyClassLine()
     */
    public function classLine(): string
    {
        return $this->readonly
            ? "readonly class {$this->className()}"
            : "class {$this->className()}";
    }

    /**
     * Get class name
     *
     * @link PhpClassTest::classLine()
     * @link PhpClassTest::readonlyClassLine()
     */
    public function className(): string
    {
        return pathinfo($this->File->name, PATHINFO_FILENAME);
    }

    /**
     * Properties used in the class
     *
     * @link PhpClassTest::properties()
     */
    public function properties(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(Property $Property) => $Property->render(), $this->properties)
        );
    }
}