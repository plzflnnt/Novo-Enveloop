<?php

/**
 * Arquivo de helpers globais do Enveloop
 * Este arquivo é carregado automaticamente pelo composer.json
 */

if (!function_exists('format_currency')) {
    /**
     * Formata valor em centavos para moeda brasileira
     *
     * @param int $valueInCents
     * @return string
     */
    function format_currency(int $valueInCents): string
    {
        return \App\Helpers\CurrencyHelper::formatCurrency($valueInCents);
    }
}

if (!function_exists('parse_currency')) {
    /**
     * Converte string de moeda para centavos
     *
     * @param string $formattedValue
     * @return int
     */
    function parse_currency(string $formattedValue): int
    {
        return \App\Helpers\CurrencyHelper::parseCurrency($formattedValue);
    }
}

if (!function_exists('currency_color')) {
    /**
     * Retorna a classe CSS baseada no valor
     *
     * @param int $valueInCents
     * @return string
     */
    function currency_color(int $valueInCents): string
    {
        return \App\Helpers\CurrencyHelper::getColorClass($valueInCents);
    }
}
