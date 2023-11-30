<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValido implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->validarCnpj($value)) {
            $fail('Insira um cnpj válido para ' . $attribute . ' por favor.');
        }
    }

    private function validarCnpj($cnpj): bool {
        $digitos = $this->retornarDigitos($cnpj);

        if(!$digitos) {
            return false;
        }

        $calculo1 = $this->calcularDigitos($cnpj, 5);
        $calculo2 = $this->calcularDigitos($calculo1, 6);
    
        return $calculo1 === $digitos[0] && $calculo2 === $digitos[1];
    }

    private function retornarDigitos($cnpj): string | bool {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
    
        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }
    
        return substr($cnpj, 12);
    }
    
    private function calcularDigitos($cnpj, $length): int {
        for ($i = 0, $j = $length, $soma = 0; $i < $length; $i++, $j--) {
            $soma += $cnpj[$i] * $j;
        }
    
        $resto = $soma % 11;
    
        return $resto < 2 ? 0 : 11 - $resto;
    }
}
