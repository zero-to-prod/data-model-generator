<?php

namespace Factories;

use Zerotoprod\DataModelFactory\Factory;
use Zerotoprod\DataModelGenerator\Generator\FileSystem\File;
use Zerotoprod\DataModelGenerator\Generator\Model\Model;

class PhpClassFactory
{
    use Factory;

    protected string $model = Model::class;

    protected function definition(): array
    {
        return [
            Model::namespace => 'App\\DataModels',
            Model::File => [
                File::name => 'User.php',
                File::directory => './app/DataModels',
            ],
        ];
    }

    public function make(): Model
    {
        return $this->instantiate();
    }
}