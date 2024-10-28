<?php

namespace Zerotoprod\DataModelBuilder\PhpClass;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelBuilder\Helpers\DataModel;

class Constant
{
    use DataModel;

    /** The constants docblock */
    public const  comment = 'comment';

    /** The constants visibility: public, protected, private */
    public const  visibility = 'visibility';

    /** The constants type */
    public const  type = 'type';

    /** The constants name */
    public const  name = 'name';

    /** The constants value */
    public const  value = 'value';

    /** The constants docblock */
    public string $comment;

    /** The constants visibility: public, protected, private */
    #[Describe(['default' => Visibility::public])]
    public Visibility $visibility;

    /** The constants type */
    #[Describe(['default' => null])]
    public ?string $type;

    /** The constants name */
    #[Describe(['required' => true])]
    public string $name;

    /** The constants value */
    #[Describe(['required' => true])]
    public string $value;

    /**
     * Renders the constant
     *
     * @Link ConstantTest::render()
     */
    public function render(): string
    {
        return implode(
            PHP_EOL,
            array_filter([
                $this->comment,
                "{$this->visibility->value} const $this->type $this->name = $this->value;"
            ])
        );
    }
}