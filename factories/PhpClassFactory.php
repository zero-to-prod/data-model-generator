<?php

namespace Factories;

use Zerotoprod\DataModelFactory\Factory;
use Zerotoprod\DataModelGenerator\Models\Model;

class PhpClassFactory
{
    use Factory;

    protected string $model = Model::class;

    protected function definition(): array
    {
        return [
            Model::namespace => 'App\\DataModels',
            Model::filename => 'User.php',
            Model::directory => './app/DataModels',
        ];
    }

    public function make(): Model
    {
        return $this->instantiate();
    }
}