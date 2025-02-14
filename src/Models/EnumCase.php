<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

class EnumCase
{
    use DataModel;

    /**
     * The case docblock
     *
     * @see $comment
     */
    public const comment = 'comment';

    /**
     * The case name
     *
     * @see $name
     */
    public const name = 'name';

    /**
     * Value of the case
     *
     * @see $value
     */
    public const value = 'value';

    /** The case docblock */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /** The case name */
    #[Describe(['required' => true])]
    public readonly string $name;

    /** Value of the case */
    #[Describe(['nullable'])]
    public readonly ?string $value;

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