<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'admin' => 'required'
            ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Campo nome é obrigatório!',
            'email.required' => 'Campo email é obrigatório!',
            'email.email' => 'Necessário enviar e-mail válido!',
            'email.unique' => 'Email já cadastrado!',
            'password.required' => 'Campo password é obrigatório!',
            'admin.required' => 'Campo admin é obrigatório!',

        ];
    }
}
