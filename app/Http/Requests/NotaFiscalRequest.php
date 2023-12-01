<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CnpjValido;

class NotaFiscalRequest extends FormRequest
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
            'numero' => 'required|digits:9||unique:notas_fiscais,numero,' . $this->route('notas_fiscais'),
            'valor' => 'required|numeric|min:1',
            'data_emissao' => 'required|date|before_or_equal:today',
            'cnpj_remetente' => ['required', new CnpjValido],
            'nome_remetente' => 'required|max:100',
            'cnpj_transportador' => ['required', new CnpjValido],
            'nome_transportador' => 'required|max:100',
        ];
    }
    
    public function messages() : array
    {
        return [
            'numero.required' => 'O número da nota é obrigatório.',
            'numero.digits' => 'O identificador único do documento deve possuir exatos 9 dígitos.',
            'valor.required' => 'O valor da nota fiscal é obrigatório.',
            'valor.min' => 'O valor da nota fiscal precisa ser maior que 0.',
            'data_emissao.required' => 'O Dia da emissão do documento é obrigatório.',
            'data_emissao.date' => 'Por favor, insira um dia da emissão do documento.',
            'data_emissao.before_or_equal' => 'O Dia da emissão do documento não pode ser no futuro.',
            'nome_remetente.required' => 'Por favor, insira o nome do remetente da nota.',
            'nome_remetente.max' => 'O nome do remetente da nota deve ter no máximo 100 caracteres.',
            'nome_transportador.required' => 'Por favor, insira o nome do transportador da nota.',
            'nome_transportador.max' => 'O nome do transportador da nota deve ter no máximo 100 caracteres.',
        ];
    }

}
