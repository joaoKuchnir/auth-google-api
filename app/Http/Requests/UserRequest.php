<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'email'                 => "required|email",
            'name'                  => 'required|string|max:255',
            'birth_date'            => 'sometimes|date',
            'cpf'                   => "sometimes|string|min:14|max:14|unique:users,cpf",
            'password'              => 'sometimes|string|min:3',
            'google_access_token'   => 'required|string',
            'picture'               => 'sometimes|url',
            'registration_finished' => 'sometimes|boolean',
        ];
    }

}

