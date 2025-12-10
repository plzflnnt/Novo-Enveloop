<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configurações do Enveloop
    |--------------------------------------------------------------------------
    |
    | Configurações específicas da aplicação Enveloop
    |
    */

    // Nome da aplicação
    'app_name' => env('APP_NAME', 'Envel∞p'),

    // Versão da aplicação
    'version' => '1.0.0',

    // Status (Beta, Stable, etc)
    'status' => 'Beta',

    // Moeda padrão
    'currency' => [
        'symbol' => 'R$',
        'code' => 'BRL',
        'decimal_separator' => ',',
        'thousands_separator' => '.',
    ],

    // Configurações de relatórios
    'reports' => [
        'default_months' => 13, // Quantidade padrão de meses nos relatórios
        'chart_colors' => [
            'earning' => 'rgba(1, 255, 1, 0.2)',
            'expense' => 'rgba(255, 1, 1, 0.2)',
            'earning_border' => 'rgba(1, 255, 1, 1)',
            'expense_border' => 'rgba(255, 1, 1, 1)',
        ],
    ],

    // Paginação
    'pagination' => [
        'transactions_per_page' => 30,
        'recent_transactions_home' => 5,
        'recent_transactions_envelope' => 8,
    ],

    // Cores para status
    'colors' => [
        'positive' => '#28a745',
        'negative' => '#f2756a',
        'neutral' => '#3659D6',
    ],
];
