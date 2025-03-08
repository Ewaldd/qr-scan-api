<?php

namespace App\Jobs;

use App\Models\QrScan;
use App\Services\QrScanService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\App;

class GenerateQrScanJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public QrScan        $qrScan,
        public QrScanService $qrScanService = new QrScanService(),
        public bool          $isNew = true
    )
    {
        //
    }

    /**
     * Define which queue the job should be sent to.
     */
    public function onQueue(): string
    {
        return 'qr-code';
    }

    public function uniqueId(): string
    {
        return $this->qrScan->id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (App::runningInConsole()) {
            return;
        }

        info('Generating qr code for: ' . $this->qrScan->id);
        $this->qrScanService->generateQrScan($this->qrScan);
    }
}
