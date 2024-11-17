<?php

namespace App\Validator;

class PhoneValidator
{
    public static function validate(array $data): ?array
    {
        $errors = [];

        // Verificar se os dados obrigatórios estão presentes
        if (empty($data['phone_type']) || empty($data['phone_number'])) {
            $errors[] = 'Tipo de telefone e número de telefone são obrigatórios.';
        }

        // Validar tipo de telefone
        if (isset($data['phone_type']) && !in_array($data['phone_type'], ['mobile', 'fixed'])) {
            $errors[] = 'Tipo de telefone inválido. Use Celular ou Fixo.';
        }

        return !empty($errors) ? $errors : null;
    }
}
