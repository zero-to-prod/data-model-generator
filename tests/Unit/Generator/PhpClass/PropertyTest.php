<?php

namespace Tests\Unit\Generator\PhpClass;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\DataModelGenerator\Models\Property;
use Zerotoprod\DataModelGenerator\Models\Visibility;

class PropertyTest extends TestCase
{
    /** @link Property::render() */
    #[Test] public function render(): void
    {
        $Property = Property::from([
            Property::comment => '/** Comment */',
            Property::visibility => Visibility::public,
            Property::readonly => true,
            Property::types => ['App\\User'],
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
            public readonly App\User \$name;
            PHP,
            $Property->render()
        );
    }
}