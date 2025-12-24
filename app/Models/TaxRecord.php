<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxRecord extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'period_month',
        'period_year',
        'gross_revenue',
        'tax_base',
        'tax_amount',
        'tax_type',
        'status',
        'payment_date',
        'payment_proof',
        'notes',
    ];

    protected $casts = [
        'period_month' => 'integer',
        'period_year' => 'integer',
        'gross_revenue' => 'decimal:2',
        'tax_base' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function getPeriodLabelAttribute(): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[$this->period_month] . ' ' . $this->period_year;
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
