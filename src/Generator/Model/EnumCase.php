<?php

namespace Zerotoprod\DataModelGenerator\Generator\Model;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Generator\Helpers\DataModel;

class EnumCase
{
    use DataModel;

    /** The case docblock */
    public const comment = 'comment';

    /** The case name */
    public const name = 'name';

    /** Value of the case */
    public const value = 'value';

    /** The case docblock */
    #[Describe(['missing_as_null' => true])]
    private readonly ?string $comment;

    /** The case name */
    #[Describe(['required' => true])]
    private readonly string $name;

    /** Value of the case */
    #[Describe(['missing_as_null' => true])]
    private readonly ?string $value;

    public function render(): string
    {
        return implode(PHP_EOL, array_filter([
            $this->comment,
            implode(' ', array_filter([
                'case',
                $this->name,
                $this->value ? '= '.$this->value : '',
            ])).';'
        ]));
    }
}