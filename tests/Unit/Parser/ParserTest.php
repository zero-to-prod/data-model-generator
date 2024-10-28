<?php

namespace Tests\Unit\Parser;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\FileSystem\File;
use Zerotoprod\DataModelGenerator\FileSystem\FileSystem;
use Zerotoprod\DataModelGenerator\Model\Constant;
use Zerotoprod\DataModelGenerator\Model\Model;
use Zerotoprod\DataModelGenerator\Model\Property;
use Zerotoprod\DataModelGenerator\Model\Visibility;
use Zerotoprod\DataModelGenerator\Parser;

class ParserTest extends TestCase
{
    /** @link Parser::generate() */
    #[Test] public function generateClass(): void
    {
        Parser::generate([
            FileSystem::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::File => [
                        File::directory => self::$test_dir,
                        File::name => 'User.php',
                    ],
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

    /** @link Parser::generate() */
    #[Test] public function generate(): void
    {
        Parser::generate([
            FileSystem::Models => [
                [
                    Model::namespace => 'App\\DataModels',
                    Model::File => [
                        File::directory => self::$test_dir,
                        File::name => 'User.php',
                    ],
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