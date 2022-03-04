<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @return void
     */
    public function test_check_if_store_fields_are_correct()
    {
        $product = new Product();
        $expected = [
            'store_id',
            'name',
            'value',
            'active',
        ];
        $arrayCompared = array_diff($expected, $product->getFillable());

        $this->assertEmpty($arrayCompared);
    }

    /**
     * @return void
     */
    public function test_check_if_store_has_relationship_store()
    {
        $this->assertTrue(method_exists(Product::class, 'store'));
    }
}
