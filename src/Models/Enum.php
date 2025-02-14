<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;
use Zerotoprod\DataModelGenerator\Helpers\RendersClassComponents;
use Zerotoprod\File\File;

class Enum
{
    use DataModel;
    use RendersClassComponents;
    use File;

    /**
     * The Fully Qualified Namespace of the enum
     *
     * @see $namespace
     */
    public const namespace = 'namespace';

    /**
     * Imports used in the enum
     *
     * @see $imports
     */
    public const imports = 'imports';

    /**
     * Specifies the enum comment
     *
     * @see $comment
     */
    public const comment = 'comment';

    /**
     * The enum backing
     *
     * @see $backed_type
     */
    public const backed_type = 'backed_type';

    /**
     * Traits used in the enum
     *
     * @see $use_statements
     */
    public const use_statements = 'use_statements';

    /**
     * Constants used in the enum
     *
     * @see $constants
     */
    public const constants = 'constants';

    /**
     * Cases used in the enum
     *
     * @see $cases
     */
    public const cases = 'cases';

    /**
     * The filename of the file.
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

    /** The Fully Qualified Namespace of the enum */
    #[Describe(['nullable'])]
    public readonly ?string $namespace;

    /** Imports used in the enum */
    #[Describe(['default' => []])]
    public readonly array $imports;

    /** Specifies the enum comment */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /** The enum backing */
    #[Describe(['nullable'])]
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
        'cast' => [self::class, 'resolveConstants'],
        'type' => Constant::class,
    ])]
    public readonly array $constants;

    public static function resolveConstants($value): array
    {
        return array_combine(
            array_keys($value),
            array_map(
                static fn(string $name, array $constant) => Constant::from(array_merge([Constant::name => $name], $constant)),
                array_keys($value),
                $value
            )
        );
    }

    /**
     * Cases used in the enum
     *
     * @var EnumCase[]
     */
    #[Describe([
        'cast' => [self::class, 'resolveCases'],
        'type' => EnumCase::class,
    ])]
    public readonly array $cases;

    public static function resolveCases($value): array
    {
        return array_combine(
            array_keys($value),
            array_map(
                static fn(string $name, array $constant) => EnumCase::from(array_merge([EnumCase::name => $name], $constant)),
                array_keys($value),
                $value
            )
        );
    }

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
            $this->cases(),
            '}'
        ]));
    }

    public function save(): string
    {
        return $this->put($this->render());
    }

    public function classLine(): string
    {
        return $this->backed_type
            ? "enum {$this->filename()}: {$this->backed_type->value}"
            : "enum {$this->filename()}";
    }

    public function cases(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(EnumCase $Case) => $Case->render(), $this->cases)
        );
    }
}