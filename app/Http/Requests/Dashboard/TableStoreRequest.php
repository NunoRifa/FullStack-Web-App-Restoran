<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Table;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tables_id' => ['required', 'string', 'max:255', 'unique:tables,tables_id'],
            'tables_name' => ['required', 'string', 'max:255'],
            'tables_capacity' => ['required', 'integer', 'min:1', 'max:127'], // max 127 (TinyInt limit)
            'tables_location' => ['nullable', 'string', 'max:255'],
            'tables_status' => ['required', Rule::in(Table::STATUSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'tables_id.required' => __('validation.required', ['attribute' => __('Kode Meja')]),
            'tables_id.string' => __('validation.string', ['attribute' => __('Kode Meja')]),
            'tables_id.max' => __('validation.max', ['attribute' => __('Kode Meja'), 'max' => 255]),
            'tables_name.required' => __('validation.required', ['attribute' => __('Nama/Nomor Meja')]),
            'tables_name.string' => __('validation.string', ['attribute' => __('Nama/Nomor Meja')]),
            'tables_name.max' => __('validation.max', ['attribute' => __('Nama/Nomor Meja'), 'max' => 255]),
            'tables_capacity.required' => __('validation.required', ['attribute' => __('Kapasitas Meja')]),
            'tables_capacity.integer' => __('validation.integer', ['attribute' => __('Kapasitas Meja')]),
            'tables_capacity.min' => __('validation.min', ['attribute' => __('Kapasitas Meja'), 'min' => 1]),
            'tables_capacity.max' => __('validation.max', ['attribute' => __('Kapasitas Meja'), 'max' => 127]),
            'tables_location.string' => __('validation.string', ['attribute' => __('Lokasi Meja')]),
            'tables_location.max' => __('validation.max', ['attribute' => __('Lokasi Meja'), 'max' => 255]),
            'tables_status.in' => __('validation.in', ['attribute' => __('Status Meja')]),
        ];
    }
}
