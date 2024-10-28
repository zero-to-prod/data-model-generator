<?php

namespace Tests\Unit\PhpClass;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\PhpClass\Property;
use Zerotoprod\DataModelGenerator\PhpClass\Visibility;

class PropertyTest extends TestCase
{
    /** @link Property::render() */
    #[Test] public function render(): void
    {
        $Property = Property::from([
            Property::comment => '/** Comment */',
            Property::visibility => Visibility::public,
            Property::type => 'App\\User',
            Property::name => 'name',
            Property::attributes => [
                "\ZeroToProd\DataModel\Describe(['required' => true])",
                "\ZeroToProd\DataModel\Describe(['required' => true])"
            ]
        ]);

        $this->assertEquals(
            <<<PHP
            /** Comment */
            \ZeroToProd\DataModel\Describe(['required' => true])
            \ZeroToProd\DataModel\Describe(['required' => true])
            public App\User \$name;
            PHP,
            $Property->render()
        );
    }
}