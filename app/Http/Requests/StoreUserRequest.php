<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  //assuming the user is authorized
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:App\Models\User'],
            'user_name' => ['required', 'unique:App\Models\User', 'regex:/^[\w\d.-]*$/'],
            'name' => ['sometimes'],
        ];
    }

    protected function prepareForValidation() {
        
        $this->merge([
            'user_name' => $this->userName  //converting JSON format into SQL
        ]);
    }

}
