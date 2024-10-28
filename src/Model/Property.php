<?php

namespace Zerotoprod\DataModelGenerator\Model;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Property
{
    use DataModel;

    /** The property docblock */
    public const comment = 'comment';

    /** The property visibility: public, protected, private */
    public const visibility = 'visibility';

    /** Applies readonly modifier. */
    public const readonly = 'readonly';

    /** The property type */
    public const type = 'type';

    /** The property name */
    public const name = 'name';

    /** Attributes of the property */
    public const attributes = 'attributes';

    /** The property docblock */
    #[Describe(['missing_as_null' => true])]
    private readonly ?string $comment;

    /** The property visibility: public, protected, private */
    #[Describe(['default' => Visibility::public])]
    private readonly Visibility $visibility;

    #[Describe(['default' => false])]
    private readonly bool $readonly;

    /** The property type */
    #[Describe(['default' => null])]
    private readonly ?string $type;

    /** The property name */
    #[Describe(['required' => true])]
    private readonly string $name;

    /** Attributes of the property */
    #[Describe(['missing_as_null' => true])]
    private readonly ?array $attributes;

    /**
     * Renders the property
     *
     * @Link PropertyTest::render()
     */
    public function render(): string
    {
        return implode(PHP_EOL, array_filter([
            $this->comment,
            implode(PHP_EOL, $this->attributes ?? []),
            implode(" ", array_filter([
                $this->visibility->value,
                $this->readonly ? 'readonly' : null,
                $this->type,
                "$$this->name",
            ])).';'
        ]));
    }
}