<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use App\Notifications\CreateUpdateProductNotification;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Services\StoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 *
 */
class NotificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_nothing_sent()
    {
        Notification::fake();
        Notification::assertNothingSent();
    }

    /**
     * @return void
     */
    public function test_create_product_notification_sent()
    {
        Notification::fake();

        $store = Store::factory()->create();

        (new ProductService(new ProductRepository(new Product())))->createProduct([
            'store_id' => $store->id,
            'name' => 'Test',
            'value' => 10,
            'active' => false,
        ]);

        Notification::assertSentTo($store, CreateUpdateProductNotification::class);
    }

    /**
     * @return void
     */
    public function test_update_product_notification_sent()
    {
        Notification::fake();

        $store = Store::factory()->create();
        $product = Product::factory()->create();

        (new ProductService(new ProductRepository(new Product())))->updateProduct($product->id, [
            'name' => 'Test',
        ]);

        Notification::assertSentTo($store, CreateUpdateProductNotification::class);
    }
}
