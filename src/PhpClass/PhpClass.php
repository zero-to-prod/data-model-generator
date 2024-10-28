<?php

namespace Zerotoprod\DataModelGenerator\PhpClass;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\FileSystem\File;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class PhpClass
{
    use DataModel;

    /** The Fully Qualified Namespace of the class */
    public const  namespace = 'namespace';

    /** Imports used in the class */
    public const  imports = 'imports';

    /** Specifies a class */
    public const  readonly = 'readonly';

    /** Specifies the class comment */
    public const  comment = 'comment';

    /** Traits used in the class */
    public const  use_statements = 'use_statements';

    /** Constants used in the class */
    public const  constants = 'constants';

    /** Properties used in the class */
    public const  properties = 'properties';

    /** File details for the PhpClass */
    public const  File = 'File';

    /** The Fully Qualified Namespace of the class*/
    #[Describe(['required' => true])]
    public string $namespace;

    /** Imports used in the class */
    #[Describe(['default' => []])]
    public array $imports;

    /** Specifies a class*/
    #[Describe(['default' => false])]
    public bool $readonly;

    /** Specifies the class comment */
    #[Describe(['missing_as_null' => true])]
    public ?string $comment;

    /** Traits used in the class */
    #[Describe(['default' => []])]
    public array $use_statements;

    /**
     * Constants used in the class
     *
     * @var Constant[]
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Constant::class,
    ])]
    public array $constants;

    /**
     * Properties used in the class
     *
     * @var Property[]
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Property::class,
    ])]
    public array $properties;

    /** File details for the PhpClass */
    #[Describe(['required' => true])]
    public File $File;

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
     * Returns the Fully Qualified namespace line
     *
     * @link PhpClassTest::namespaceLine()
     */
    public function namespaceLine(): string
    {
        return "namespace $this->namespace;";
    }

    /**
     * Imports used in the class
     *
     * @link PhpClassTest::imports()
     */
    public function imports(): string
    {
        return implode(
            PHP_EOL,
            array_map(
                static fn(string $statement) => "use $statement;",
                $this->imports
            )
        );
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
            ? "class {$this->className()}"
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
        return pathinfo($this->File->filename, PATHINFO_FILENAME);
    }

    /**
     * Traits used in the class
     *
     * @link PhpClassTest::useStatements()
     */
    public function useStatements(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(string $statement) => "use $statement;",
                $this->use_statements
            )
        );
    }

    /**
     * Constants used in the class
     *
     * @link PhpClassTest::constants()
     */
    public function constants(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(Constant $Constant) => $Constant->render(), $this->constants)
        );
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