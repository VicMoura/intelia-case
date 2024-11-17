<?php

namespace App\Validator;

class AddressValidator
{
    public static function validate(array $data, bool $isUpdate = false): array
    {
        $errors = [];

        // Verificar se os campos obrigatórios estão presentes, considerando o update
        if (!$isUpdate) {
            if (empty($data['street']) || empty($data['number']) || empty($data['zip_code']) || empty($data['city']) || empty($data['state'])) {
                $errors[] = 'Os campos "Rua", "Número", "CEP", "Cidade" e "Estado" são obrigatórios.';
            }
        }

        // Verificar se o campo "street" é uma string válida
        if (isset($data['street']) && (!is_string($data['street']) || strlen($data['street']) < 3)) {
            $errors[] = 'O campo "Rua" deve ter pelo menos 3 caracteres.';
        }

        // Verificar se o campo "number" é numérico
        if (isset($data['number']) && !is_numeric($data['number'])) {
            $errors[] = 'O campo "Número" deve ser numérico.';
        }

        // Validar o "zip_code" (CEP) - formato brasileiro
        if (isset($data['zip_code']) && !preg_match('/^\d{5}-\d{3}$/', $data['zip_code'])) {
            $errors[] = 'O campo "CEP" deve estar no formato "XXXXX-XXX".';
        }

        // Verificar se o campo "city" é uma string válida
        if (isset($data['city']) && (!is_string($data['city']) || strlen($data['city']) < 3)) {
            $errors[] = 'O campo "Cidade" deve ter pelo menos 3 caracteres.';
        }

        // Verificar se o campo "state" é uma string válida
        if (isset($data['state']) && (!is_string($data['state']) || strlen($data['state']) < 2)) {
            $errors[] = 'O campo "Estado" deve ter pelo menos 2 caracteres.';
        }

        return $errors;
    }
}
