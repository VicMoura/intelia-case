<?php

namespace App\Validator;

class UserValidator
{
    public static function validate(array $data, bool $isUpdate = false): array
    {
        $errors = [];

        // Verificar se todos os campos obrigatórios estão presentes, considerando o update
        if (!$isUpdate && (empty($data['full_name']) || empty($data['birth_date']))) {
            $errors[] = 'O Nome completo e a Data de Nascimento são obrigatórios.';
        }

        // Verificar se o campo "full_name" é uma string válida
        if (isset($data['full_name']) && (!is_string($data['full_name']) || strlen($data['full_name']) < 3)) {
            $errors[] = 'O  Nome Completo deve ter pelo menos 3 caracteres.';
        }

        // Validar a data de nascimento, apenas se foi passada
        if (isset($data['birth_date'])) {
            $birthDate = \DateTime::createFromFormat('d/m/Y', $data['birth_date']);
            if (!$birthDate || $birthDate->format('d/m/Y') !== $data['birth_date']) {
                $errors[] = 'A data de nascimento deve estar no formato válido DD/MM/YYYY.';
            }

            // Verificar se a data de nascimento não é no futuro
            if ($birthDate > new \DateTime()) {
                $errors[] = 'A data de nascimento não pode ser no futuro.';
            }
        }

        return $errors;
    }
}
