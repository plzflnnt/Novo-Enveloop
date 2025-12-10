<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Converte valor em centavos para formato de moeda brasileiro
     * Exemplo: 150000 -> "1 500,00"
     *
     * @param int $valueInCents Valor em centavos
     * @return string Valor formatado
     */
    public static function formatCurrency(int $valueInCents): string
    {
        $value = $valueInCents / 100;
        return number_format($value, 2, ',', ' ');
    }

    /**
     * Converte string de moeda brasileira para centavos (inteiro)
     * Exemplo: "R$ 1 500,00" ou "1.500,00" -> 150000
     *
     * @param string $formattedValue Valor formatado
     * @return int Valor em centavos
     */
    public static function parseCurrency(string $formattedValue): int
    {
        // Remove símbolos de moeda, espaços e pontos (separador de milhares)
        $cleaned = str_replace(['R$', 'R', '$', ' ', '.'], '', $formattedValue);
        
        // Remove a vírgula decimal
        $cleaned = str_replace(',', '', $cleaned);
        
        // Remove caracteres não numéricos
        $cleaned = preg_replace('/[^0-9]/', '', $cleaned);
        
        return (int) $cleaned;
    }

    /**
     * Formata valor em centavos com símbolo R$
     * Exemplo: 150000 -> "R$ 1.500,00"
     *
     * @param int $valueInCents Valor em centavos
     * @return string Valor formatado com símbolo
     */
    public static function formatWithSymbol(int $valueInCents): string
    {
        $value = $valueInCents / 100;
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    /**
     * Retorna a cor apropriada para exibição baseada no valor
     *
     * @param int $valueInCents Valor em centavos
     * @return string Classe CSS Tailwind ou código de cor
     */
    public static function getColorClass(int $valueInCents): string
    {
        return $valueInCents < 0 ? 'text-red-600' : 'text-green-600';
    }

    /**
     * Retorna a cor hex apropriada para exibição baseada no valor
     *
     * @param int $valueInCents Valor em centavos
     * @return string Código de cor hexadecimal
     */
    public static function getColorHex(int $valueInCents): string
    {
        return $valueInCents < 0 ? '#f2756a' : '#28a745';
    }
}
