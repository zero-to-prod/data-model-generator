<?php

namespace Factories;

use Zerotoprod\DataModelBuilder\FileSystem\File;
use Zerotoprod\DataModelBuilder\PhpClass\PhpClass;
use Zerotoprod\DataModelFactory\Factory;

class PhpClassFactory
{
    use Factory;

    protected string $model = PhpClass::class;

    protected function definition(): array
    {
        return [
            PhpClass::namespace => 'App\\DataModels',
            PhpClass::File => [
                File::filename => 'User.php',
                File::directory => './app/DataModels',
            ],
        ];
    }

    public function make(): PhpClass
    {
        return $this->instantiate();
    }
}