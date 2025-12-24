<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'transaction_id',
        'entry_number',
        'date',
        'description',
        'notes',
        'is_posted',
    ];

    protected $casts = [
        'date' => 'date',
        'is_posted' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(JournalLine::class);
    }

    public function getTotalDebit(): float
    {
        return $this->lines()->sum('debit');
    }

    public function getTotalCredit(): float
    {
        return $this->lines()->sum('credit');
    }

    public function isBalanced(): bool
    {
        return $this->getTotalDebit() === $this->getTotalCredit();
    }

    public static function generateEntryNumber(int $tenantId): string
    {
        $year = now()->year;
        $lastEntry = self::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->orderByDesc('id')
            ->first();

        $sequence = $lastEntry ? intval(substr($lastEntry->entry_number, -4)) + 1 : 1;

        return sprintf('JE-%d-%04d', $year, $sequence);
    }
}
