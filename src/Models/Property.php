<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class Property
{
    use DataModel;

    /**
     * The property docblock
     *
     * @see  $comment
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comment = 'comment';

    /**
     * The property docblock
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /**
     * The property visibility: public, protected, private
     *
     * @see  $visibility
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const visibility = 'visibility';

    /**
     * The property visibility: public, protected, private
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => Visibility::public])]
    public readonly Visibility $visibility;

    /**
     * Applies readonly modifier.
     *
     * @see  $readonly
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const readonly = 'readonly';

    /**
     * Applies readonly modifier.
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => false])]
    public readonly bool $readonly;

    /**
     * The property types
     *
     * @see  $types
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const types = 'types';

    /**
     * The property types
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public readonly array $types;

    /**
     * The property name
     *
     * @see  $name
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const name = 'name';

    /**
     * The property name
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['required' => true])]
    public readonly string $name;

    /**
     * Attributes of the property
     *
     * @see  $attributes
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const attributes = 'attributes';

    /**
     * Attributes of the property
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['default' => []])]
    public readonly array $attributes;

    /**
     * Renders the property
     *
     * @Link PropertyTest::render()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function render(): string
    {
        return implode(PHP_EOL, array_filter([
            $this->comment,
            implode(PHP_EOL, $this->attributes),
            implode(' ', array_filter([
                $this->visibility->value,
                $this->readonly ? 'readonly' : null,
                implode('|', $this->types),
                "$$this->name",
            ])).';'
        ]));
    }
}