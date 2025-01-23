<?php

namespace Tests\Unit\Generator\PhpClass;

use Factories\PhpClassFactory;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class PhpClassTest extends TestCase
{

    /** @link Model::render() */
    #[Test] public function render(): void
    {
        $PhpClass = Model::from([
            Model::namespace => 'App\\DataModels',
            Model::imports => [
                'use App\\DataModel;',
                'use ZeroToProd\\DataModel\\DataModel;',
            ],
            Model::readonly => true,
            Model::use_statements => [
                'use DataModel;'
            ],
            Model::filename => 'User.php',
            Model::constants => [
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
            Model::properties => [
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::public,
                    Property::types => ['App\\User'],
                    Property::name => 'User',
                    Property::attributes => [
                        "\ZeroToProd\DataModel\Describe(['required' => true])"
                    ]
                ],
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::private,
                    Property::types => ['string'],
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
            readonly class User
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

    /** @link Model::namespaceLine() */
    #[Test] public function namespaceLine(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(Model::namespace, 'App\\DataModels')
            ->make();

        $this->assertEquals(
            expected: 'namespace App\\DataModels;',
            actual: $PhpClass->namespaceLine()
        );
    }

    /** @link Model::imports() */
    #[Test] public function imports(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(Model::imports, [
                'use App\\DataModel;',
                'use ZeroToProd\\DataModel\\DataModel;',
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

    /** @link Model::classLine() */
    #[Test] public function classLine(): void
    {
        $PhpClass = PhpClassFactory::factory()->make();

        $this->assertEquals('class User', $PhpClass->classLine());
    }

    /** @link Model::classLine() */
    #[Test] public function readonlyClassLine(): void
    {
        $PhpClass = PhpClassFactory::factory([
            Model::readonly => true,
            Model::filename => 'User.php',
        ])->make();

        $this->assertEquals('readonly class User', $PhpClass->classLine());
    }

    /** @link Model::useStatements() */
    #[Test] public function useStatements(): void
    {
        $PhpClass = PhpClassFactory::factory()
            ->set(Model::use_statements, ['use DataModel;'])
            ->make();

        $this->assertEquals(
            <<<PHP
            use DataModel;
            PHP,
            $PhpClass->useStatements()
        );
    }

    /** @link Model::constants() */
    #[Test] public function constants(): void
    {
        $PhpClass = PhpClassFactory::factory([
            Model::constants => [
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

    /** @link Model::properties() */
    #[Test] public function properties(): void
    {
        $PhpClass = PhpClassFactory::factory([
            Model::properties => [
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::public,
                    Property::types => ['App\\User'],
                    Property::name => 'User',
                ],
                [
                    Property::comment => '/** Comment */',
                    Property::visibility => Visibility::private,
                    Property::types => ['string'],
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