<?php

namespace App\Services;

use App\Jobs\GenerateQrScanJob;
use App\Models\QrScan;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrScanService
{
    private const QR_SCAN_FILE_EXTENSION = '.png';
    private const QR_SCAN_STORAGE_PATH = 'qr_scans';
    public function create(array $data): QrScan
    {
        $qrScan = auth()->user()->qr_scans()->create($data);

        GenerateQrScanJob::dispatch($qrScan);

        return $qrScan;
    }

    public function getScansForUser()
    {
        return auth()->user()->qr_scans()->get();
    }

    public function update(QrScan $qrScan, array $data): QrScan
    {
        $qrScan->update($data);

        return $qrScan;
    }

    public function generateQrScan(Qrscan $qrScan): VOID
    {
        $path = Storage::disk(self::QR_SCAN_STORAGE_PATH)->path($qrScan->id . self::QR_SCAN_FILE_EXTENSION);

        QrCode::generate($qrScan->link, $path);
    }

    public function getUrlForQrScan(QrScan $qrScan): string
    {
        return Storage::url(self::QR_SCAN_STORAGE_PATH . '/' . $qrScan->id . self::QR_SCAN_FILE_EXTENSION);
    }
}
