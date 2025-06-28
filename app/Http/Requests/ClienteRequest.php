<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $clienteId = $this->route('cliente'); // útil para update()
        $clienteId = $clienteId instanceof \App\Models\Cliente ? $clienteId->id : $clienteId;

        return [
            'tipo_clientes_id' => 'required|in:1,2',
            'nif' => 'required|string|max:20|unique:clientes,nif,' . $clienteId . ',id',

            // Pessoa Singular
            'nome' => 'required_if:tipo_clientes_id,1|nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
            'generos_id' => 'required_if:tipo_clientes_id,1|nullable|exists:generos,id',
            'estado_civil_id' => 'required_if:tipo_clientes_id,1|nullable|exists:estado_civil,id',
            'nacionalidade' => 'nullable|string|max:100',

            // Pessoa Coletiva
            'nome_social' => 'required_if:tipo_clientes_id,2|nullable|string|max:255',
            'nome_fantasia' => 'required_if:tipo_clientes_id,2|nullable|string|max:255',
            'tipo_empresa' => 'required_if:tipo_clientes_id,2|nullable|string|max:100',
            'responsavel' => 'required_if:tipo_clientes_id,2|nullable|string|max:255',
            'data_registo' => 'required_if:tipo_clientes_id,2|nullable|date',

            // Endereço
            'municipios_id' => 'required|exists:municipios,id',
            'endereco' => 'required|string|max:255',
            'bairro' => 'nullable|string|max:255',

            // Contactos
            'contactos.*.id' => 'nullable|integer|exists:contactos,id',
            'contactos.*.telefone' => 'nullable|string|max:20',
            'contactos.*.email' => 'nullable|email|max:255',

            // Documentos
            'documentos.*.id' => 'nullable|integer|exists:documentos,id',
            'documentos.*.tipo_documentos_id' => 'required|exists:tipo_documentos,id',
            'documentos.*.numero' => 'required|string|max:100',
            'documentos.*.emissao' => 'nullable|date',
            'documentos.*.validade' => 'nullable|date|after_or_equal:documentos.*.emissao',
            'documentos.*.path' => 'nullable',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipo_clientes_id.required' => 'O tipo de cliente é obrigatório.',
            'tipo_clientes_id.in' => 'Tipo de cliente inválido.',

            'nif.required' => 'O NIF é obrigatório.',
            'nif.unique' => 'Este NIF já está registado.',
            'nif.max' => 'O NIF não pode ter mais de 20 caracteres.',

            // Pessoa Singular
            'nome.required_if' => 'O nome é obrigatório para cliente singular.',
            'data_nascimento.required_if' => 'A data de nascimento é obrigatória para cliente singular.',
            'generos_id.required_if' => 'O género é obrigatório para cliente singular.',
            'generos_id.exists' => 'O género selecionado é inválido.',
            'estado_civil_id.required_if' => 'O estado civil é obrigatório para cliente singular.',
            'estado_civil_id.exists' => 'O estado civil selecionado é inválido.',
            'nacionalidade.required_if' => 'A nacionalidade é obrigatória para cliente singular.',

            // Pessoa Coletiva
            'nome_social.required_if' => 'O nome social é obrigatório para cliente coletivo.',
            'nome_fantasia.required_if' => 'O nome fantasia é obrigatório para cliente coletivo.',
            'tipo_empresa.required_if' => 'O tipo de empresa é obrigatório para cliente coletivo.',
            'responsavel.required_if' => 'O responsável é obrigatório para cliente coletivo.',
            'data_registo.required_if' => 'A data de registo é obrigatória para cliente coletivo.',

            // Endereço
            'municipios_id.required' => 'O município é obrigatório.',
            'municipios_id.exists' => 'O município selecionado é inválido.',
            'endereco.required' => 'O endereço é obrigatório.',
            'bairro.required' => 'O bairro é obrigatório.',

            // Contactos
            'contactos.*.telefone.max' => 'O telefone não pode exceder 20 caracteres.',
            'contactos.*.email.email' => 'O email informado não é válido.',
            'contactos.*.email.max' => 'O email não pode exceder 255 caracteres.',

            // Documentos
            'documentos.*.tipo_documentos_id.required' => 'O tipo de documento é obrigatório.',
            'documentos.*.tipo_documentos_id.exists' => 'O tipo de documento selecionado é inválido.',
            'documentos.*.numero.required' => 'O número do documento é obrigatório.',
            'documentos.*.emissao.date' => 'A data de emissão deve ser uma data válida.',
            'documentos.*.validade.date' => 'A validade deve ser uma data válida.',
            'documentos.*.validade.after_or_equal' => 'A validade do documento deve ser posterior ou igual à data de emissão.',
            'documentos.*.path.file' => 'O arquivo deve ser um ficheiro válido.',
            'documentos.*.path.mimes' => 'O documento deve ser do tipo: pdf, jpg ou png.',
            'documentos.*.path.max' => 'O tamanho máximo do documento é de 2MB.',

            // Validações do tipo string
            'nif.string' => 'O NIF deve ser um texto.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome_social.string' => 'O nome social deve ser um texto.',
            'nome_fantasia.string' => 'O nome fantasia deve ser um texto.',
            'tipo_empresa.string' => 'O tipo de empresa deve ser um texto.',
            'responsavel.string' => 'O nome do responsável deve ser um texto.',
            'nacionalidade.string' => 'A nacionalidade deve ser um texto.',
            'endereco.string' => 'O endereço deve ser um texto.',
            'bairro.string' => 'O bairro deve ser um texto.',
            'contactos.*.telefone.string' => 'O telefone deve ser um texto.',
            'contactos.*.email.string' => 'O email deve ser um texto.',
            'documentos.*.numero.string' => 'O número do documento deve ser um texto.',

            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_registo.date' => 'A data de registo deve ser uma data válida.',
        ];
    }
}
