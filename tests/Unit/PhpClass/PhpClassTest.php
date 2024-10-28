<?php

namespace Tests\Unit\PhpClass;

use Factories\PhpClassFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelBuilder\FileSystem\File;
use Zerotoprod\DataModelBuilder\PhpClass\Constant;
use Zerotoprod\DataModelBuilder\PhpClass\PhpClass;
use Zerotoprod\DataModelBuilder\PhpClass\Property;
use Zerotoprod\DataModelBuilder\PhpClass\Visibility;

class PhpClassTest extends TestCase
{

    /** @link PhpClass::render() */
    #[Test] public function render(): void
    {
        $PhpClass = PhpClass::from([
            PhpClass::namespace => 'App\\DataModels',
            PhpClass::imports => [
                'App\\DataModel',
                'ZeroToProd\\DataModel\\DataModel',
            ],
            PhpClass::readonly => true,
            PhpClass::use_statements => [
                'DataModel'
            ],
            PhpClass::File => [
                File::filename => 'User.php',
            ],
            PhpClass::constants => [
                [
                    Constant::comment => '/** Comment */',
                    Constant::visibility => Visibility::public,
                    Constant::type => 'string',
                    Constant::name => 'name',
                    Constant::value => "'name'",
                ],
                [
                    Constant::comment => '/** Comment */',
                    Constant::visibility => Visibility::private,
                    Constant::type => 'bool',
                    Constant::name => 'bool',
                    Constant::value => "true",
                ]
            ],
            PhpClass::properties => [
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::public,
                    Property::type => 'App\\User',
                    Property::name => 'User',
                    Property::attributes => [
                        "\ZeroToProd\DataModel\Describe(['required' => true])"
                    ]
                ],
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::private,
                    Property::type => 'string',
                    Property::name => 'name',
                    Property::attributes => [
                        "\ZeroToProd\DataModel\Describe(['required' => true])"
                    ]
                ]
            ]
        ]);

        $this->assertEquals(
            <<<PHP
            <?php
            namespace App\DataModels;
            use App\DataModel;
            use ZeroToProd\DataModel\DataModel;
            class User
            {
            use DataModel;
            /** Comment */
            public const string name = 'name';
            /** Comment */
            private const bool bool = true;
            /** Comment */
            \ZeroToProd\DataModel\Describe(['required' => true])
            public App\User \$User;
            /** Comment */
            \ZeroToProd\DataModel\Describe(['required' => true])
            private string \$name;
            }
            PHP,
            $PhpClass->render()
        );
    }

    /** @link PhpClass::namespaceLine() */
    #[Test] public function namespaceLine(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(PhpClass::namespace, 'App\\DataModels')
            ->make();

        $this->assertEquals(
            expected: 'namespace App\\DataModels;',
            actual: $PhpClass->namespaceLine()
        );
    }

    /** @link PhpClass::imports() */
    #[Test] public function imports(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(PhpClass::imports, [
                'App\\DataModel',
                'ZeroToProd\\DataModel\\DataModel',
            ])
            ->make();

        $this->assertEquals(
            <<<PHP
            use App\DataModel;
            use ZeroToProd\DataModel\DataModel;
            PHP,
            $PhpClass->imports()
        );
    }

    /** @link PhpClass::classLine() */
    #[Test] public function classLine(): void
    {
        $PhpClass = PhpClassFactory::factory()->make();

        $this->assertEquals('class User', $PhpClass->classLine());
    }

    /** @link PhpClass::classLine() */
    #[Test] public function readonlyClassLine(): void
    {
        $PhpClass = PhpClassFactory::factory([
            PhpClass::readonly => true,
            PhpClass::File => [
                File::filename => 'User.php',
            ],
        ])->make();

        $this->assertEquals('class User', $PhpClass->classLine());
    }

    /** @link PhpClass::useStatements() */
    #[Test] public function useStatements(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(PhpClass::use_statements, ['DataModel'])
            ->make();

        $this->assertEquals(
            <<<PHP
            use DataModel;
            PHP,
            $PhpClass->useStatements()
        );
    }

    /** @link PhpClass::constants() */
    #[Test] public function constants(): void
    {
        $PhpClass = PhpClassFactory::factory([
            PhpClass::constants => [
                [
                    Constant::comment => '/** Comment */',
                    Constant::visibility => Visibility::public,
                    Constant::type => 'string',
                    Constant::name => 'name',
                    Constant::value => "'name'",
                ],
                [
                    Constant::comment => '/** Comment */',
                    Constant::visibility => Visibility::private,
                    Constant::type => 'bool',
                    Constant::name => 'bool',
                    Constant::value => "'bool'",
                ]
            ]
        ])->make();

        $this->assertEquals(
            <<<PHP
            /** Comment */
            public const string name = 'name';
            /** Comment */
            private const bool bool = 'bool';
            PHP,
            $PhpClass->constants()
        );
    }

    /** @link PhpClass::properties() */
    #[Test] public function properties(): void
    {
        $PhpClass = PhpClassFactory::factory([
            PhpClass::properties => [
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::public,
                    Property::type => 'App\\User',
                    Property::name => 'User',
                ],
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::private,
                    Property::type => 'string',
                    Property::name => 'name',
                ],
            ]
        ])->make();

        $this->assertEquals(
            <<<PHP
            /** Comment */
            public App\User \$User;
            /** Comment */
            private string \$name;
            PHP,
            $PhpClass->properties()
        );
    }
}