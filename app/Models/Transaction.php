<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'category_id',
        'date',
        'description',
        'amount',
        'type',
        'is_taxable',
        'tax_amount',
        'attachment_path',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'type' => TransactionType::class,
        'is_taxable' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isIncome(): bool
    {
        return $this->type === TransactionType::INCOME;
    }

    public function isExpense(): bool
    {
        return $this->type === TransactionType::EXPENSE;
    }
}
