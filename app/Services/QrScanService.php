<?php

namespace App\Services;

use App\Models\QrScan;

class QrScanService
{
    public function create(array $data): QrScan
    {
       return auth()->user()->qr_scans()->create($data);
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
}
