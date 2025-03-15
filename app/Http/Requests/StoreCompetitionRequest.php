<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreCompetitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('competitions', 'name')->where('year', $this->request->get('year'))
            ],
            'year' => 'bail|required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'languages' => 'nullable',
            'right_ans' => 'nullable',
            'wrong_ans' => 'nullable',
            'empty_ans' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'This competition already exists.'
        ];
    }
}
