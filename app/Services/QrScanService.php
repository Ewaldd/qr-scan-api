<?php

namespace App\Services;

use App\Models\QrScan;

class QrScanService
{

    public function createQrScan(array $data): QrScan
    {
       return auth()->user()->qr_scans()->create($data);
    }

    public function getScansForUser()
    {
        return auth()->user()->qr_scans()->get();
    }
}
