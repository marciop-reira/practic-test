<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 *
 */
class CreateUpdateProductNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Product
     */
    private $product;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(Lang::get('NEW PRODUCT CREATED/UPDATED'))
                    ->greeting(Lang::get('Hello, :name!', ['name' => $this->product->store->name]))
                    ->greeting(Lang::get('A NEW PRODUCT HAS BEEN CREATED/UPDATED.'))
                    ->line(Lang::get('Product name: :name', ['name' => $this->product->name]))
                    ->line(Lang::get('Product value: :value', ['value' => $this->product->value]))
                    ->line(Lang::get('Product active: :active', ['active' => $this->product->active]))
                    ->line(Lang::get('Thank you for using our application!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
