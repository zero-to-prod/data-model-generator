<?php

namespace Zerotoprod\DataModelGenerator\Models;

use Zerotoprod\DataModel\Describe;
use Zerotoprod\DataModelGenerator\Helpers\DataModel;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
class EnumCase
{
    use DataModel;

    /**
     * The case docblock
     *
     * @see  $comment
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const comment = 'comment';

    /**
     * The case name
     *
     * @see  $name
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const name = 'name';

    /**
     * Value of the case
     *
     * @see  $value
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public const value = 'value';

    /**
     * The case docblock
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $comment;

    /**
     * The case name
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['required' => true])]
    public readonly string $name;

    /**
     * Value of the case
     *
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    #[Describe(['nullable'])]
    public readonly ?string $value;

    /**
     * @link https://github.com/zero-to-prod/data-model-generator
     */
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