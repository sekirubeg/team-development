<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SampleFormRequest extends FormRequest
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
            'title' => 'required|string|max:25',
            'content' => 'required|string',
            'importanc' => 'required|integer|between:1,3',
            'limit' => 'required|date|after_or_equal:today',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * カスタムバリデーションメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'title.string' => 'タイトルは文字列である必要があります。',
            'title.max' => 'タイトルは最大255文字までです。',
            
            'content.required' => '内容を入力してください。',
            'content.string' => '内容は文字列である必要があります。',

            'importance.required' => '優先度を選択してください。',
            'importance.integer' => '優先度は数値である必要があります。',
            'importance.between' => '優先度は1〜3の間で選択してください。',

            'limit.required' => '期限日を入力してください。',
            'limit.date' => '有効な日付を入力してください。',
            'limit.after_or_equal' => '期限日は今日以降の日付を選択してください。',

            'image.required' => '画像をアップロードしてください。',
            'image.image' => 'アップロードできるのは画像ファイルのみです。',
            'image.mimes' => '画像の形式はjpeg, png, jpg, gifのいずれかにしてください。',
            'image.max' => '画像のサイズは最大2MBまでです。',
        ];
    }


}
