<?php

namespace App\Http\Requests\QrScans;

use Illuminate\Foundation\Http\FormRequest;

class DestroyQrScanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('qr_scan')->user_id;
    }

    public function rules(): array
    {
        return [];
    }

}
