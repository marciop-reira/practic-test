<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 *
 */
class ProductTest extends TestCase
{
    /**
     * @return void
     */
    public function test_get_all_products()
    {
        $response = $this->getJson('/api/product');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_get_all_products_with_total()
    {
        Store::factory()->create();
        Product::factory()->count(10)->create();

        $response = $this->getJson('/api/product');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');;
    }

    /**
     * @return void
     */
    public function test_get_product()
    {
        Store::factory()->create();
        $product = Product::factory()->create();

        $response = $this->get("/api/product/$product->id");

        $response->assertStatus(200)
            ->assertJson(fn ($value) => $value->has('data.store'))
            ->assertJson(fn ($value) => $value->where('data.value', "R$ $product->value,00"));
    }

    /**
     * @return void
     */
    public function test_get_product_not_found()
    {
        $response = $this->get('/api/product/1');

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_get_product_server_error_with_non_integer_id()
    {
        $response = $this->get('/api/product/fake-id');

        $response->assertStatus(500);
    }

    /**
     * @return void
     */
    public function test_create_product()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'Test',
            'value' => 10,
            'active' => 0,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function test_create_product_with_invalid_store_id()
    {
        $data = [
            'store_id' => 'fake-id',
            'name' => 'Test',
            'value' => 10,
            'active' => 0,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('store_id')
            ->assertJsonMissingValidationErrors('name')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('active');
    }

    /**
     * @return void
     */
    public function test_create_product_with_invalid_active()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'Test',
            'value' => 10,
            'active' => '1234',
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('active')
            ->assertJsonMissingValidationErrors('name')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('store_id');
    }

    /**
     * @return void
     */
    public function test_create_product_without_store_id()
    {
        $data = [
            'name' => 'Test',
            'value' => 10,
            'active' => 0,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('store_id')
            ->assertJsonMissingValidationErrors('name')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('active');
    }

    /**
     * @return void
     */
    public function test_create_product_without_name()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'value' => 10,
            'active' => 0,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('active');
    }

    /**
     * @return void
     */
    public function test_create_product_without_value()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'test',
            'active' => 0,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('name')
            ->assertJsonMissingValidationErrors('active');
    }

    /**
     * @return void
     */
    public function test_create_product_without_active()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'test',
            'value' => 12,
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('active')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('name')
            ->assertJsonMissingValidationErrors('value');
    }

    /**
     * @return void
     */
    public function test_create_product_with_name_size_less_than_3()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 't',
            'value' => 12,
            'active' => 1
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('value');
    }

    /**
     * @return void
     */
    public function test_create_product_with_name_size_greater_than_60()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'tasdf hasdfjk ahslkdf haskjd fhaksjld fjalshd fkalshd flkahsdkf lasdfk jashdfk lahsdfk as',
            'value' => 12,
            'active' => 1
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('value');
    }

    /**
     * @return void
     */
    public function test_create_product_with_value_characters_number_less_than_2()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'test',
            'value' => 1,
            'active' => 1
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_create_product_with_value_characters_number_greater_than_6()
    {
        $store = Store::factory()->create();
        $data = [
            'store_id' => $store->id,
            'name' => 'test',
            'value' => 1111111,
            'active' => 1
        ];

        $response = $this->postJson('/api/product', $data);

        $response->assertJsonValidationErrorFor('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_update_product()
    {
        Store::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'name' => 'Test',
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_update_product_not_found()
    {
        $response = $this->putJson("/api/product/0");

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_update_product_server_error_with_non_integer_id()
    {
        $response = $this->putJson("/api/product/fake-id");

        $response->assertStatus(500);
    }

    /**
     * @return void
     */
    public function test_update_product_with_invalid_store_id()
    {
        Store::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'store_id' => 'fake-id'
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('store_id')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_update_product_with_invalid_active()
    {
        Store::factory()->create();
        $product = Product::factory()->create();

        $data = [
            'active' => 'fake-value'
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('active')
            ->assertJsonMissingValidationErrors('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_update_product_with_name_size_less_than_3()
    {
        Store::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'name' => 't',
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('value');
    }

    /**
     * @return void
     */
    public function test_update_product_with_name_size_greater_than_60()
    {
        Store::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'name' => 'tasdfkja lsdfj alsdjfl asdjf kçasjdf klçajsdl fkçasjdlçf jasdlçfj asdfa sfds',
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('value');
    }

    /**
     * @return void
     */
    public function test_update_product_with_value_characters_number_less_than_2()
    {
        Store::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'value' => 1,
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_update_product_with_value_characters_number_greater_than_6()
    {
        Store::factory()->create();
        $product = Product::factory()->create();
        $data = [
            'value' => 2222222,
        ];

        $response = $this->putJson("/api/product/$product->id", $data);

        $response->assertJsonValidationErrorFor('value')
            ->assertJsonMissingValidationErrors('store_id')
            ->assertJsonMissingValidationErrors('active')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_destroy_product()
    {
        Store::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/product/$product->id");

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_destroy_product_not_found()
    {
        $response = $this->deleteJson("/api/product/0");

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_destroy_product_server_error_with_non_integer_id()
    {
        $response = $this->deleteJson("/api/product/fake-id");

        $response->assertStatus(500);
    }
}
