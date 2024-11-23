<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Property
{
    use DataModel;

    /**
     * The property docblock
     *
     * @see $comment
     */
    public const comment = 'comment';

    /**
     * The property visibility: public, protected, private
     *
     * @see $visibility
     */
    public const visibility = 'visibility';

    /**
     * Applies readonly modifier.
     *
     * @see $readonly
     */
    public const readonly = 'readonly';

    /**
     * The property type
     *
     * @see $type
     */
    public const type = 'type';

    /**
     * The property name
     *
     * @see $name
     */
    public const name = 'name';

    /**
     * Attributes of the property
     *
     * @see $attributes
     */
    public const attributes = 'attributes';

    /** The property docblock */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /** The property visibility: public, protected, private */
    #[Describe(['default' => Visibility::public])]
    public readonly Visibility $visibility;

    /** Applies readonly modifier. */
    #[Describe(['default' => false])]
    public readonly bool $readonly;

    /** The property type */
    #[Describe(['nullable'])]
    public readonly ?string $type;

    /** The property name */
    #[Describe(['required' => true])]
    public readonly string $name;

    /** Attributes of the property */
    #[Describe(['default' => []])]
    public readonly array $attributes;

    /**
     * Renders the property
     *
     * @Link PropertyTest::render()
     */
    public function render(): string
    {
        return implode(PHP_EOL, array_filter([
            $this->comment,
            implode(PHP_EOL, $this->attributes),
            implode(' ', array_filter([
                $this->visibility->value,
                $this->readonly ? 'readonly' : null,
                $this->type,
                "$$this->name",
            ])).';'
        ]));
    }
}