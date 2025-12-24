<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'type',
        'period_month',
        'period_year',
        'planned_amount',
        'notes',
    ];

    protected $casts = [
        'type' => TransactionType::class,
        'period_month' => 'integer',
        'period_year' => 'integer',
        'planned_amount' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRealizationAttribute(): float
    {
        return Transaction::where('tenant_id', $this->tenant_id)
            ->where('type', $this->type)
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->whereMonth('date', $this->period_month)
            ->whereYear('date', $this->period_year)
            ->sum('amount');
    }

    public function getVarianceAttribute(): float
    {
        return $this->planned_amount - $this->realization;
    }

    public function getPercentageAttribute(): float
    {
        if ($this->planned_amount == 0) return 0;
        return ($this->realization / $this->planned_amount) * 100;
    }
}
