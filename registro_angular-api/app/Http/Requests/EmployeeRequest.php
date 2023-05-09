<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:100'],
            'cpf' => ['required', 'min:14', 'max:14', Rule::unique('employees')],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Por favor, insira o nome',
            'name.max' => 'O nome ultrapassou o limite de 100 caracteres',
            'email.max' => 'O email ultrapassou o limite de 100 caracteres',
            'email.required' => 'Por favor, insira o e-mail',
            'email.email' => 'Por favor, insira um e-mail que seja válido',
            'cpf.unique' => 'CPF já cadastrado',
            'cpf.required' => 'Por favor insira um CPF',
            'cpf.min' => 'O CPF deve ter pelo menos 14 caracteres',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
