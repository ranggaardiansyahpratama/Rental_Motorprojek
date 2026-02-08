<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'action' => 'required|in:approve,reject',
            'daily_rate' => 'required_if:action,approve|numeric|min:10000',
            'weekly_rate' => 'required_if:action,approve|numeric|min:10000',
            'monthly_rate' => 'required_if:action,approve|numeric|min:10000',
            'admin_notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'action.required' => 'Pilih tindakan verifikasi',
            'action.in' => 'Tindakan verifikasi tidak valid',
            'daily_rate.required_if' => 'Harga sewa harian harus diisi',
            'daily_rate.numeric' => 'Harga sewa harian harus berupa angka',
            'daily_rate.min' => 'Harga sewa harian minimal Rp 10.000',
            'weekly_rate.required_if' => 'Harga sewa mingguan harus diisi',
            'weekly_rate.numeric' => 'Harga sewa mingguan harus berupa angka',
            'weekly_rate.min' => 'Harga sewa mingguan minimal Rp 10.000',
            'monthly_rate.required_if' => 'Harga sewa bulanan harus diisi',
            'monthly_rate.numeric' => 'Harga sewa bulanan harus berupa angka',
            'monthly_rate.min' => 'Harga sewa bulanan minimal Rp 10.000',
            'admin_notes.max' => 'Catatan admin maksimal 500 karakter',
        ];
    }
}