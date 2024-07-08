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
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $number_of_tables
 * @property \Illuminate\Support\Carbon $reservation_datetime
 * @property string|null $special_request
 * @property bool $is_confirmed
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ReservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereIsConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereNumberOfTables($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereReservationDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereSpecialRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation withoutTrashed()
 * @mixin \Eloquent
 */
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
