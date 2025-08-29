<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Helpers\RendersClassComponents;
use Zerotoprod\File\File;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Model
{
    use DataModel;
    use RendersClassComponents;
    use File;

    /**
     * The filename of the file including the extension:
     * ```
     * User.php
     * ```
     *
     * @see  $filename
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const filename = 'filename';

    /**
     * The directory of the file.
     *
     * @see  $directory
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const directory = 'directory';

    /**
     * The Fully Qualified Namespace of the class
     *
     * @see  $namespace
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const namespace = 'namespace';

    /**
     * The Fully Qualified Namespace of the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $namespace;

    /**
     * Imports used in the class
     *
     * @see  $imports
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const imports = 'imports';

    /**
     * Imports used in the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /**
     * Specifies a class
     *
     * @see  $readonly
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const readonly = 'readonly';

    /**
     * Specifies a class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public readonly bool $readonly;

    /**
     * Specifies the class comment
     *
     * @see  $comment
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comment = 'comment';

    /**
     * Specifies the class comment
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /**
     * Traits used in the class
     *
     * @see  $use_statements
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const use_statements = 'use_statements';

    /**
     * Traits used in the class
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public readonly array $use_statements;

    /**
     * Constants used in the class
     *
     * @see  $constants
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const constants = 'constants';

    /**
     * Constants used in the class
     *
     * @var array<string, Constant> $constants
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe([
        'cast' => [self::class, 'resolveConstants'],
        'type' => Constant::class,
    ])]
    public readonly array $constants;

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public static function resolveConstants($value): array
    {
        return array_combine(
            array_keys($value ?? []),
            array_map(
                static fn(string $name, array $constant) => Constant::from(array_merge([Constant::name => $name], $constant)),
                array_keys($value ?? []),
                $value ?? []
            )
        );
    }

    /**
     * Properties used in the class
     *
     * @see  $properties
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const properties = 'properties';

    /**
     * Properties used in the class
     *
     * @var array<string, Property> $properties
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe([
        'cast' => [self::class, 'resolveProperties'],
        'type' => Property::class,
    ])]
    public readonly array $properties;

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public static function resolveProperties($value): array
    {
        return array_combine(
            array_keys($value ?? []),
            array_map(
                static fn(string $name, array $property) => Property::from(array_merge([Property::name => $name], $property)),
                array_keys($value ?? []),
                $value ?? []
            )
        );
    }

    /**
     * Renders the class
     *
     * @link PhpClassTest::render()
     * @link https://github.com/zero-to-prod/data-model-generator
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

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function save(): string
    {
        return $this->put($this->render());
    }

    /**
     * Returns class line
     *
     * @link PhpClassTest::classLine()
     * @link PhpClassTest::readonlyClassLine()
     * @link https://github.com/zero-to-prod/data-model-generator
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
     * @link https://github.com/zero-to-prod/data-model-generator
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