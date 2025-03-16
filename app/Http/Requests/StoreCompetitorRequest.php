<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCompetitorRequest extends FormRequest
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
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('competitors', 'user_id')->where('round_id', $this->request->get('round_id'))
            ],
            'round_id' => [
                'required',
                'exists:rounds,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'The user has already been assigned to this round.'
        ];
    }
}
