<?php

namespace App\Http\Requests\QrScans;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQrScanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('qr_scan')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'link' => ['sometimes', 'url'],
            'description' => ['sometimes', 'string'],
        ];
    }
}
