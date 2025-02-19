<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveHotelRequest extends FormRequest
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
        $hotelIdRule = request()->method() == 'POST' ? 'nullable' : 'required|exists:hotels,hotel_id';
        return [
            'hotel_id' => $hotelIdRule,
            'hotel_name' => 'required|string|max:60',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'hotel_name.required' => 'ホテル名は必須です。',
            'hotel_name.string' => 'ホテル名はチェーンである必要があります。',
            'hotel_name.max' => 'ホテル名は最大 60 文字で入力できます。',
            'prefecture_id.required' => '州への入国が必要です。',
            'prefecture_id.exists' => '無効な県です。',
            'image.image' => 'アップロードするファイルは画像ファイルである必要があります。',
            'image.mimes' => 'アップロードするファイルは、jpeg、png、jpg 形式である必要があります。',
            'image.max' => 'ファイルアップロード最大2MB。',
        ];
    }
}
