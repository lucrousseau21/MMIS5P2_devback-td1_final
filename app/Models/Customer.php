<?php

namespace App\Models;

use App\Enums\CustomerGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Panier;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gender' => CustomerGender::class,
    ];

    protected $with = [
        'user',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function panier()
    {
        // return $this->hasOne(Panier::class, 'customer_id', 'id');
        return $this->hasOne(Panier::class);

    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
