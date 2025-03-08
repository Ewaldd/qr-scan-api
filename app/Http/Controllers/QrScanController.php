<?php

namespace App\Http\Controllers;

use App\Http\Resources\QrScanResource;
use App\Models\QrScan;
use App\Http\Requests\StoreQrScanRequest;
use App\Http\Requests\UpdateQrScanRequest;
use App\Services\QrScanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class QrScanController extends Controller
{
    public function __construct(
        public QrScanService $qrScanService = new QrScanService()
    )
    {

    }

    public function index(): JsonResponse
    {
        $qrScans = $this->qrScanService->getScansForUser();

        return response()->json(QrscanResource::collection($qrScans), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQrScanRequest $request): JsonResponse
    {
        $qrScan = $this->qrScanService->createQrScan($request->validated());

        return response()->json(new QrScanResource($qrScan), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(QrScan $qrScan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QrScan $qrScan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQrScanRequest $request, QrScan $qrScan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QrScan $qrScan)
    {
        //
    }
}
