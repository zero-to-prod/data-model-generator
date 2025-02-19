<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Constant
{
    use DataModel;

    /**
     * The constants docblock
     *
     * @see  $comment
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comment = 'comment';

    /**
     * The constants visibility: public, protected, private
     *
     * @see  $visibility
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const visibility = 'visibility';

    /**
     * The constants type
     *
     * @see  $type
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const type = 'type';

    /**
     * The constants name
     *
     * @see  $name
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const name = 'name';

    /**
     * The constants value
     *
     * @see  $value
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const value = 'value';

    /**
     * The constants docblock
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public ?string $comment;

    /**
     * The constants visibility: public, protected, private
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => Visibility::public])]
    public readonly Visibility $visibility;

    /**
     * The constants type
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $type;

    /**
     * The constants name
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['required' => true])]
    public readonly string $name;

    /**
     * The constants value
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['required' => true])]
    public readonly string $value;

    /**
     * Renders the constant
     *
     * @Link ConstantTest::render()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function render(): string
    {
        return implode(
            PHP_EOL,
            array_filter([
                $this->comment,
                implode(' ', array_filter([
                    $this->visibility->value,
                    'const',
                    $this->type,
                    $this->name,
                    '=',
                    $this->value
                ])).';'
            ])
        );
    }
}