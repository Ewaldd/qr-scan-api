<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrScans\DestroyQrScanRequest;
use App\Http\Requests\QrScans\ShowQrScanRequest;
use App\Http\Requests\QrScans\StoreQrScanRequest;
use App\Http\Requests\QrScans\UpdateQrScanRequest;
use App\Http\Resources\QrScanResource;
use App\Models\QrScan;
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
        $qrScan = $this->qrScanService->create($request->validated());

        return response()->json(new QrScanResource($qrScan), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(QrScan $qrScan, ShowQrScanRequest $request)
    {
        return response()->json(new QrScanResource($qrScan), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQrScanRequest $request, QrScan $qrScan): JsonResponse
    {
        $qrScan = $this->qrScanService->update($qrScan, $request->validated());

        return response()->json(new QrScanResource($qrScan), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyQrScanRequest $request, QrScan $qrScan)
    {
        $qrScan->delete();

        return response()->json(['message' => 'QrScan deleted successful'], Response::HTTP_OK);
    }
}
