<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRoundRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && Auth::user()->is_admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'competition_id' => [
                'required',
                'max:20',
                'exists:competitions,id'
            ],
            'round_number' => [
                'required',
                'max:11',
                Rule::unique('rounds', 'round_number')->where('competition_id', $this->request->get('competition_id'))
            ],
            'date' => 'required',
        ];
    }
}
