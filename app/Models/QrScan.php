<?php

namespace App\Models;

use App\Services\QrScanService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrScan extends Model
{
    /** @use HasFactory<\Database\Factories\QrScanFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'description',
        'link',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getQrScan(): string
    {
        $qrScanService = new QrScanService();
        return $qrScanService->getUrlForQrScan($this);
    }
}
