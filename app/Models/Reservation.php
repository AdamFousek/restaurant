<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ReservationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ReservationObserver::class])]
class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'number_of_tables',
        'reservation_datetime',
        'special_request',
        'is_confirmed',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'number_of_tables' => 'integer',
            'special_request' => 'string',
            'reservation_datetime' => 'datetime',
            'is_confirmed' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
