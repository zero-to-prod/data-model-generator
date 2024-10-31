<?php

namespace Zerotoprod\DataModelGenerator\Generator\Helpers;

use Zerotoprod\DataModelGenerator\Generator\Model\Constant;

trait ClassHelper
{
    /**
     * Returns the Fully Qualified namespace line
     *
     * @link PhpClassTest::namespaceLine()
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
     */
    public function imports(): string
    {
        return implode(
            PHP_EOL,
            array_map(
                static fn(string $statement) => "use $statement;",
                $this->imports
            )
        );
    }

    /**
     * Traits used in the class
     *
     * @link PhpClassTest::useStatements()
     */
    public function useStatements(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(string $statement) => "use $statement;",
                $this->use_statements
            )
        );
    }

    /**
     * Constants used in the class
     *
     * @link PhpClassTest::constants()
     */
    public function constants(): string
    {
        return implode(
            PHP_EOL,
            array_map(static fn(Constant $Constant) => $Constant->render(), $this->constants)
        );
    }
}