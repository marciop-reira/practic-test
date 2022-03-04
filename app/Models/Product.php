<?php

namespace App\Models;

use App\Notifications\CreateUpdateProductNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

/**
 *
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'store_id',
        'name',
        'value',
        'active',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'active' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function sendCreateUpdateProductNotification()
    {
        Notification::send($this->store, new CreateUpdateProductNotification($this));
    }
}
