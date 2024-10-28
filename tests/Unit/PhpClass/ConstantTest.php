<?php

namespace Tests\Unit\PhpClass;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\PhpClass\Constant;
use Zerotoprod\DataModelGenerator\PhpClass\Visibility;

class ConstantTest extends TestCase
{
    /** @link Constant::render() */
    #[Test] public function render(): void
    {
        $Constant = Constant::from([
            Constant::comment => '/** Comment */',
            Constant::visibility => Visibility::public,
            Constant::type => 'string',
            Constant::name => 'name',
            Constant::value => "'name'",
        ]);

        $this->assertEquals(
            <<<PHP
            /** Comment */
            public const string name = 'name';
            PHP,
            $Constant->render()
        );
    }
}