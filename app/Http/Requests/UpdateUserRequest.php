<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT') {
            return [
                'user_name' => ['required', 'unique:App\Models\User', 'regex:/^\p{Latin}+$/'],
                'name' => ['required'],
            ];
        } else {
            return [
                'user_name' => ['sometimes', 'unique:App\Models\User', 'regex:/^\p{Latin}+$/'],
                'name' => ['sometimes'],
            ];
        }

        
    }

    protected function prepareForValidation() {
        
       if($this->userName) {
            $this->merge([
                'user_name' => $this->userName  //converting JSON format into SQL
            ]);
       }
    }
}
