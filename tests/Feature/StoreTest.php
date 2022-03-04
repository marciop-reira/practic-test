<?php

namespace Tests\Feature;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 *
 */
class StoreTest extends TestCase
{
    /**
     * @return void
     */
    public function test_get_all_stores()
    {
        $response = $this->getJson('/api/store');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_get_all_stores_with_total()
    {
        Store::factory()->count(10)->create();

        $response = $this->get('/api/store');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');;
    }

    /**
     * @return void
     */
    public function test_get_store()
    {
        $store = Store::factory()->create();

        $response = $this->get("/api/store/$store->id");

        $response->assertStatus(200)
            ->assertJson(function ($value){
                return $value->has('data.products');
            });
    }

    /**
     * @return void
     */
    public function test_get_store_not_found()
    {
        $response = $this->get('/api/store/1');

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_get_store_server_error_with_non_integer_id()
    {
        $response = $this->get('/api/store/fake-id');

        $response->assertStatus(500);
    }

    /**
     * @return void
     */
    public function test_create_store()
    {
        $data = [
            'name' => 'Store Test',
            'email' => 'store@test.com',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function test_create_store_without_name()
    {
        $data = [
            'email' => 'store@test.com',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertJsonValidationErrorFor('name');
    }

    /**
     * @return void
     */
    public function test_create_store_without_email()
    {
        $data = [
            'name' => 'Store Test',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertJsonValidationErrorFor('email');
    }

    /**
     * @return void
     */
    public function test_create_store_with_invalid_email()
    {
        $data = [
            'name' => 'Store Test',
            'email' => 'store.com',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertJsonValidationErrorFor('email')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_create_store_with_name_size_less_than_3()
    {
        $data = [
            'name' => 'St',
            'email' => 'store@test.com',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertJsonMissingValidationErrors('email')
            ->assertJsonValidationErrorFor('name');
    }

    /**
     * @return void
     */
    public function test_create_store_with_name_size_greater_than_40()
    {
        $data = [
            'name' => 'Store asdhfasd fhasdf haskdf haskdf hasdkf asdf',
            'email' => 'store@test.com',
        ];

        $response = $this->postJson('/api/store', $data);

        $response->assertJsonMissingValidationErrors('email')
            ->assertJsonValidationErrorFor('name');
    }

    /**
     * @return void
     */
    public function test_create_store_with_duplicated_email()
    {
        $data = [
            'name' => 'Store',
            'email' => 'store@test.com',
        ];

        $this->postJson('/api/store', $data);
        $response = $this->postJson('/api/store', $data);

        $response->assertJsonMissingValidationErrors('name')
            ->assertJsonValidationErrorFor('email');
    }

    /**
     * @return void
     */
    public function test_update_store()
    {
        $store = Store::factory()->create();

        $data = [
            'name' => 'Store',
            'email' => 'store@test.com',
        ];

        $response = $this->putJson("/api/store/$store->id", $data);

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_update_store_not_found()
    {
        $response = $this->putJson("/api/store/0");

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_update_store_server_error_with_non_integer_id()
    {
        $response = $this->putJson("/api/store/fake-id");

        $response->assertStatus(500);
    }

    /**
     * @return void
     */
    public function test_update_store_with_invalid_email()
    {
        $store = Store::factory()->create();

        $data = [
            'name' => 'Store',
            'email' => 'store.com',
        ];

        $response = $this->putJson("/api/store/$store->id", $data);

        $response->assertJsonValidationErrorFor('email')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_update_store_with_name_size_less_than_3()
    {
        $store = Store::factory()->create();

        $data = [
            'name' => 'St',
            'email' => 'store@test.com',
        ];

        $response = $this->putJson("/api/store/$store->id", $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('email');
    }

    /**
     * @return void
     */
    public function test_update_store_with_name_size_greater_than_40()
    {
        $store = Store::factory()->create();

        $data = [
            'name' => 'St asd fasd fasd fasd fasd fasd fadsf asdf asdf asdf as',
            'email' => 'store@test.com',
        ];

        $response = $this->putJson("/api/store/$store->id", $data);

        $response->assertJsonValidationErrorFor('name')
            ->assertJsonMissingValidationErrors('email');
    }

    /**
     * @return void
     */
    public function test_update_store_with_duplicated_email()
    {
        $store1 = Store::factory()->create();
        $store2 = Store::factory()->create();

        $data = [
            'email' => $store1->email,
        ];

        $response = $this->putJson("/api/store/$store2->id", $data);

        $response->assertJsonValidationErrorFor('email')
            ->assertJsonMissingValidationErrors('name');
    }

    /**
     * @return void
     */
    public function test_destroy_store()
    {
        $store = Store::factory()->create();

        $response = $this->deleteJson("/api/store/$store->id");

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_destroy_store_not_found()
    {
        $response = $this->deleteJson("/api/store/0");

        $response->assertNotFound();
    }

    /**
     * @return void
     */
    public function test_destroy_store_server_error_with_non_integer_id()
    {
        $response = $this->deleteJson("/api/store/fake-id");

        $response->assertStatus(500);
    }
}
