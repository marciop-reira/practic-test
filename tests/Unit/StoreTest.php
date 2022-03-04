<?php

namespace Tests\Unit;

use App\Models\Store;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class StoreTest extends TestCase
{

    /**
     * @return void
     */
    public function test_check_if_store_fields_are_correct()
    {
        $store = new Store();
        $expected = [
            'name',
            'email',
        ];
        $arrayCompared = array_diff($expected, $store->getFillable());

        $this->assertEmpty($arrayCompared);
    }

    /**
     * @return void
     */
    public function test_check_if_store_has_relationship_products()
    {
        $this->assertTrue(method_exists(Store::class, 'products'));
    }
}
