<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        $rules=[
            //
            'title'     => 'required|string|max:255',
            'author'    => 'nullable|string|max:255',
            'isbn'      => ['string',$this->isMethod('post') ? 'unique:books,isbn' : 'nullable',],
            'remaining' => 'integer',
            'uuid'      => 'nullable|uuid',
            'status'    => 'in:available,borrowed',
        ];
        
        return $rules;
    }
}
