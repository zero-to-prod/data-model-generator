<?php

namespace Zerotoprod\DataModelGenerator\PhpClass;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class Property
{
    use DataModel;

    /** The property docblock */
    public const  comment = 'comment';

    /** The property visibility: public, protected, private */
    public const  visibility = 'visibility';

    /** The property type */
    public const  type = 'type';

    /** The property name */
    public const  name = 'name';

    /** Attributes of the property */
    public const  attributes = 'attributes';

    /** The property docblock */
    #[Describe(['missing_as_null' => true])]
    private ?string $comment;

    /** The property visibility: public, protected, private */
    #[Describe(['default' => Visibility::public])]
    private Visibility $visibility;

    /** The property type */
    #[Describe(['default' => null])]
    private ?string $type;

    /** The property name */
    #[Describe(['required' => true])]
    private string $name;

    /** Attributes of the property */
    #[Describe(['missing_as_null' => true])]
    private ?array $attributes;

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
            "{$this->visibility->value} $this->type $$this->name;"
        ]));
    }
}