<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
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
            'title'=>['required'],
            'description'=>['required'],
            'start_date'=>['required'],
            'end_date'=>['required'],
            'start_time'=>['required'],
            'end_time'=>['required'],
            'address'=>['required'],
            'event_image'=>['required','image']
        ];
    }
}