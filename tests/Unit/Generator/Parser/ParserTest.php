<?php

namespace Tests\Unit\Generator\Parser;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Generator\Engine;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Generator\Model\Constant;
use Zerotoprod\DataModelGenerator\Generator\Model\Model;
use Zerotoprod\DataModelGenerator\Generator\Model\Property;
use Zerotoprod\DataModelGenerator\Generator\Model\Visibility;

class ParserTest extends TestCase
{
    /** @link Engine::generate() */
    #[Test] public function generateClass(): void
    {
        Engine::generate([
            FileSystem::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::directory => self::$test_dir,
                    Model::filename => 'User.php',
                ]
            ]
        ]);

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
        Engine::generate([
            FileSystem::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::directory => self::$test_dir,
                    Model::filename => 'User.php',
                    Model::imports => [
                        'Zerotoprod\\DataModel\\DataModel'
                    ],
                    Model::use_statements => [
                        'DataModel'
                    ],
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
                    ],
                    Model::properties => [
                        [
                            Property::comment => '/** Comment */',
                            Property::visibility => Visibility::public,
                            Property::type => 'App\\User',
                            Property::name => 'User',
                            Property::attributes => [
                                "\ZeroToProd\DataModel\Describe(['required' => true])",
                                "\ZeroToProd\DataModel\Describe(['required' => true])"
                            ]
                        ],
                        [
                            Property::visibility => Visibility::private,
                            Property::type => 'string',
                            Property::name => 'name',
                        ]
                    ]
                ]
            ]
        ]);

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
                public const string name = 'name';
                /** Comment */
                private const bool bool = 'bool';
                /** Comment */
                \ZeroToProd\DataModel\Describe(['required' => true])
                \ZeroToProd\DataModel\Describe(['required' => true])
                public App\User \$User;
                private string \$name;
                }
                PHP
        );
    }
}