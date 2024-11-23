<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Helpers\RendersClassComponents;
use Zerotoprod\File\File;

class Model
{
    use DataModel;
    use RendersClassComponents;
    use File;

    /**
     * The Fully Qualified Namespace of the class
     *
     * @see $namespace
     */
    public const namespace = 'namespace';

    /**
     * Imports used in the class
     *
     * @see $imports
     */
    public const imports = 'imports';

    /**
     * Specifies a class
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /**
     * Specifies the class comment
     *
     * @see $comment
     */
    public const comment = 'comment';

    /**
     * Traits used in the class
     *
     * @see $use_statements
     */
    public const use_statements = 'use_statements';

    /**
     * Constants used in the class
     *
     * @see $constants
     */
    public const constants = 'constants';

    /**
     * Properties used in the class
     *
     * @see $properties
     */
    public const properties = 'properties';

    /**
     * The filename of the file including the extension:
     * ```
     * User.php
     * ```
     *
     * @see $filename
     */
    public const filename = 'filename';

    /**
     * The directory of the file.
     *
     * @see $directory
     */
    public const directory = 'directory';

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
     * @var array<string, Property> $properties
     */
    #[Describe([
        'cast' => [self::class, 'mapOf'],
        'type' => Property::class,
    ])]
    public readonly array $properties;

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
        return $this->put($this->render());
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
            ? "readonly class {$this->filename()}"
            : "class {$this->filename()}";
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
            array_map(static fn(Property $Property) => $Property->render(),
                $this->properties
            )
        );
    }
}