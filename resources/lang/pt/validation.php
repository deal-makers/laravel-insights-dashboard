<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'O :attribute deve ser aceito.',
    'limited'              => 'Este texto tem um limite de :attribute caracteres.',
    'active_url'           => 'O :attribute não é um URL válido.',
    'after'                => 'O :attribute deve ser uma data depois :date.',
    'after_or_equal'       => 'O :attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O :attribute pode conter apenas letras.',
    'alpha_dash'           => 'O :attribute pode conter apenas letras, números e travessões.',
    'alpha_num'            => 'O :attribute pode conter apenas letras e números.',
    'array'                => 'O :attribute deve ser um array.',
    'before'               => 'O :attribute deve ser uma data antes :date.',
    'before_or_equal'      => 'O :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O :attribute deve estar entre :min e :max.',
        'file'    => 'O :attribute deve estar entre :min e :max kilobytes.',
        'string'  => 'O :attribute deve estar entre :min e :max caracteres.',
        'array'   => 'O :attribute deve estar entre :min e :max itens.',
    ],
    'boolean'              => 'O :attribute campo deve ser verdadeiro ou falso.',
    'confirmed'            => 'O :attribute a confirmação não corresponde.',
    'date'                 => 'O :attribute não é uma data válida.',
    'date_format'          => 'O :attribute não corresponde ao formato :format.',
    'different'            => 'O :attribute e :other devem ser diferentes.',
    'digits'               => 'O :attribute deve ser :digits dígitos.',
    'digits_between'       => 'O :attribute deve estar entre :min e :max dígitos.',
    'dimensions'           => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O :attribute campo tem um valor duplicado.',
    'email'                => 'O :attribute deve ser um endereço de e-mail válido.',
    'exists'               => 'O :attribute selecionado é inválido.',
    'file'                 => 'O :attribute deve ser um arquivo.',
    'filled'               => 'O :attribute campo deve ter um valor.',
    'image'                => 'O :attribute deve ser uma imagem.',
    'in'                   => 'O :attribute selecionado é inválido.',
    'in_array'             => 'O :attribute campo não existe em :other.',
    'integer'              => 'O :attribute deve ser um inteiro.',
    'ip'                   => 'O :attribute deve ser um endereço IP válido.',
    'json'                 => 'O :attribute deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => 'O :attribute não pode ser maior que :max.',
        'file'    => 'O :attribute não pode ser maior que :max kilobytes.',
        'string'  => 'O :attribute não pode ser maior que :max caracteres.',
        'array'   => 'O :attribute não pode ser maior que :max itens.',
    ],
    'mimes'                => 'O :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O :attribute deve ser pelo menos :min.',
        'file'    => 'O :attribute deve ser pelo menos :min kilobytes.',
        'string'  => 'O :attribute deve ter pelo menos :min caracteres.',
        'array'   => 'O :attribute deve ter pelo menos :min itens.',
    ],
    'not_in'               => 'O selected :attribute é inválido.',
    'numeric'              => 'O :attribute deve ser um número.',
    'present'              => 'O :attribute campo deve estar presente.',
    'regex'                => 'O :attribute formato é inválido.',
    'required'             => 'O :attribute campo é obrigatório.',
    'required_if'          => 'O :attribute campo é obrigatório quando :other é :value.',
    'required_unless'      => 'O :attribute campo é obrigatório a menos :other é em :values.',
    'required_with'        => 'O :attribute campo é obrigatório quando :values não está presente.',
    'required_with_all'    => 'O :attribute campo é obrigatório quando :values não está presente.',
    'required_without'     => 'O :attribute campo é obrigatório quando :values não está presente.',
    'required_without_all' => 'O :attribute campo é obrigatório quando nenhum :values estão presentes.',
    'same'                 => 'O :attribute e :other deve combinar.',
    'size'                 => [
        'numeric' => 'O :attribute deve ser :size.',
        'file'    => 'O :attribute deve ser :size kilobytes.',
        'string'  => 'O :attribute deve ser :size characters.',
        'array'   => 'O :attribute deve conter :size itens.',
    ],
    'string'               => 'O :attribute deve ser uma string.',
    'timezone'             => 'O :attribute deve ser uma zona válida.',
    'unique'               => 'O :attribute já foi recebido.',
    'uploaded'             => 'O :attribute falhou ao enviar.',
    'url'                  => 'O :attribute formato é inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
