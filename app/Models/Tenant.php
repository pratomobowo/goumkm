<?php

namespace App\Models;

use App\Enums\TaxStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_type',
        'npwp',
        'address',
        'phone',
        'email',
        'has_inventory',
        'tax_status',
        'subscription_status',
    ];

    protected $casts = [
        'has_inventory' => 'boolean',
        'tax_status' => TaxStatus::class,
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function taxRecords(): HasMany
    {
        return $this->hasMany(TaxRecord::class);
    }
}
