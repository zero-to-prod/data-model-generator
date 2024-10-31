<?php

namespace Tests\Unit\Generator\PhpClass;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Model\Constant;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;

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