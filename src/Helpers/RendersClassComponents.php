<?php

namespace Zerotoprod\DataModelGenerator\Helpers;

use Zerotoprod\DataModelGenerator\Models\Constant;

/**
 * @link https://github.com/zero-to-prod/data-model-generator
 */
trait RendersClassComponents
{
    /**
     * Returns the Fully Qualified namespace line
     *
     * @link PhpClassTest::namespaceLine()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function namespaceLine(): string
    {
        return isset($this->namespace)
            ? "namespace $this->namespace;"
            : '';
    }

    /**
     * Imports used in the class
     *
     * @link PhpClassTest::imports()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function imports(): string
    {
        return implode(
            PHP_EOL,
            array_map(
                static fn(string $statement) => $statement,
                $this->imports
            )
        );
    }

    /**
     * Traits used in the class
     *
     * @link PhpClassTest::useStatements()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function useStatements(): string
    {
        return implode(PHP_EOL, $this->use_statements);
    }

    /**
     * Constants used in the class
     *
     * @link PhpClassTest::constants()
     * @link https://github.com/zero-to-prod/data-model-generator
     */
    public function constants(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(Constant $Constant) => $Constant->render(), $this->constants)
        );
    }
}