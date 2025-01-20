<?php

namespace Tests\Unit\Generator\Parser;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Engine;
use Zerotoprod\DataModelGenerator\Models\Components;
use Zerotoprod\DataModelGenerator\Models\Constant;
use Zerotoprod\DataModelGenerator\Models\Model;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class ParserTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generateClass(): void
    {
        Engine::generate(Components::from([
            Components::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::directory => self::$test_dir,
                    Model::filename => 'User.php',
                ]
            ]
        ]));

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                namespace App\DataModels;
                class User
                {
                }
                PHP
        );
    }

    /** @link Engine::generate() */
    #[Test] public function generate(): void
    {
        Engine::generate(Components::from([
            Components::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::directory => self::$test_dir,
                    Model::filename => 'User.php',
                    Model::imports => [
                        'Zerotoprod\\DataModel\\DataModel'
                    ],
                    Model::use_statements => [
                        'use DataModel;'
                    ],
                    Model::constants => [
                        'name' => [
                            Constant::comment => '/** Comment */',
                            Constant::visibility => Visibility::public,
                            Constant::type => 'string',
                            Constant::value => "'name'",
                        ],
                        'bool' => [
                            Constant::comment => '/** Comment */',
                            Constant::visibility => Visibility::private,
                            Constant::type => 'bool',
                            Constant::value => "'bool'",
                        ]
                    ],
                    Model::properties => [
                        'User' => [
                            Property::comment => '/** Comment */',
                            Property::visibility => Visibility::public,
                            Property::type => 'App\\User',
                            Property::attributes => [
                                "\ZeroToProd\DataModel\Describe(['required' => true])",
                                "\ZeroToProd\DataModel\Describe(['required' => true])"
                            ]
                        ],
                        'name' => [
                            Property::visibility => Visibility::private,
                            Property::type => 'string',
                        ]
                    ]
                ]
            ]
        ]));

        self::assertStringEqualsFile(
            expectedFile: self::$test_dir.'/User.php',
            actualString: <<<PHP
                <?php
                namespace App\DataModels;
                use Zerotoprod\DataModel\DataModel;
                class User
                {
                use DataModel;
                /** Comment */
                public const name = 'name';
                /** Comment */
                private const bool = 'bool';
                \ZeroToProd\DataModel\Describe(['required' => true])
                \ZeroToProd\DataModel\Describe(['required' => true])
                public App\User \$User;
                private string \$name;
                }
                PHP
        );
    }
}