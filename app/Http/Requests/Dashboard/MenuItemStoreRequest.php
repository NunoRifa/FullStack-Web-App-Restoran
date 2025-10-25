<?php

namespace App\Http\Requests\Dashboard;

use App\Models\MenuItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemStoreRequest extends FormRequest
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
            'menu_items_name' => ['required', 'string', 'max:255'],
            'menu_items_description' => ['nullable', 'string', 'max:255'],
            'menu_items_price' => ['required', 'integer', 'min:0'],
            'menu_items_category' => ['required', 'string', 'max:255'],
            'is_active' => ['required', Rule::in(MenuItem::STATUSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'menu_items_name.required' => __('validation.required', ['attribute' => __('Nama Menu')]),
            'menu_items_name.string' => __('validation.string', ['attribute' => __('Nama Menu')]),
            'menu_items_name.max' => __('validation.max', ['attribute' => __('Nama Menu'), 'max' => 255]),
            'menu_items_description.string' => __('validation.string', ['attribute' => __('Deskripsi Menu')]),
            'menu_items_description.max' => __('validation.max', ['attribute' => __('Deskripsi Menu'), 'max' => 255]),
            'menu_items_price.required' => __('validation.required', ['attribute' => __('Harga Menu')]),
            'menu_items_price.integer' => __('validation.integer', ['attribute' => __('Harga Menu')]),
            'menu_items_price.min' => __('validation.min', ['attribute' => __('Harga Menu'), 'min' => 0]),
            'menu_items_category.required' => __('validation.required', ['attribute' => __('Kategori Menu')]),
            'menu_items_category.string' => __('validation.string', ['attribute' => __('Kategori Menu')]),
            'menu_items_category.max' => __('validation.max', ['attribute' => __('Kategori Menu'), 'max' => 255]),
            'is_active.in' => __('validation.in', ['attribute' => __('Status Menu')]),
        ];
    }
}
