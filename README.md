<p align="center">
<a href="#" target="_blank">
<!-- Você pode trocar este emoji por uma logo .png se tiver -->
<img src="https://img.icons8.com/fluency/96/wallet.png" alt="Enveloop Logo" width="80">
</a>
</p>

<h1 align="center">Enveloop</h1>

<p align="center">
<strong>Controle financeiro inteligente baseado no Método dos Envelopes.</strong>
</p>

<p align="center">
<a href="#-sobre">Sobre</a> •
<a href="#-features">Funcionalidades</a> •
<a href="#-stack">Tecnologias</a> •
<a href="#-arquitetura">Arquitetura</a> •
<a href="#-instalação">Instalação</a>
</p>

Sobre

O Enveloop é uma aplicação Full-Stack desenvolvida para facilitar a gestão de orçamento pessoal. Diferente das planilhas comuns, ele utiliza a lógica do "Método dos Envelopes": o usuário define categorias (envelopes) e distribui seu saldo disponível entre elas, garantindo que o dinheiro tenha um destino antes mesmo de ser gasto.

O projeto foi construído com foco em Clean Code, performance e uma interface mobile-first responsiva.


Features

 Gestão de Envelopes: Criação e personalização de categorias orçamentárias.

 Dashboard Interativo: Visão geral do saldo livre vs. saldo alocado.

 Relatórios Mensais: Acompanhamento visual de gastos via gráficos.

Stack

Este projeto utiliza as tecnologias mais modernas do ecossistema PHP:

Categoria

Tecnologias

Back-end

Laravel 11, PHP 8.2+

Front-end

Blade Templates, Tailwind CSS, Alpine.js

Database

MySQL (Produção), SQLite (Dev/Testes)

Build Tools

Vite, PostCSS

DevOps

Docker (Sail)

Arquitetura e Destaques

O código foi estruturado pensando em escalabilidade e manutenção, fugindo do padrão "Fat Controller".

Service Layer Pattern

A lógica de negócios complexa foi extraída dos Controllers e isolada em Camadas de Serviço:

App\Services\BalanceService: Gerencia cálculos de saldo livre e alocações.

App\Services\EnvelopeService: Lida com a lógica de movimentação entre envelopes.

App\Services\ReportService: Prepara os dados para os relatórios mensais.

🔹 Helpers e Traits

Para evitar repetição de código (DRY):

CurrencyHelper: Padronização de formatação monetária (BRL) em toda a aplicação.

🔹 Segurança

Proteção CSRF em todos os formulários.

Validação robusta de Requests (LoginRequest, ProfileUpdateRequest).

Sanitização de dados de entrada.

Instalação

Siga os passos abaixo para rodar o projeto localmente:

Pré-requisitos

PHP 8.2+

Composer

Node.js & NPM

Passo a Passo

Clone o repositório

git clone [https://github.com/seu-usuario/novo-enveloop.git](https://github.com/seu-usuario/novo-enveloop.git)
cd novo-enveloop


Instale as dependências do PHP

composer install


Instale as dependências do Frontend

npm install


Configure o ambiente

cp .env.example .env
php artisan key:generate


Configure o Banco de Dados

Crie um banco de dados vazio (ex: enveloop).

Ajuste as credenciais no arquivo .env.

Rode as migrações e seeders (opcional):

php artisan migrate --seed


Inicie o servidor

# Em um terminal:
npm run dev

# Em outro terminal:
php artisan serve


Acesse http://localhost:8000 e aproveite!

Este projeto está sob a licença [MIT license](https://opensource.org/licenses/MIT).

<p align="center">
Feito com 💙 por <a href="https://zafalon.com">Paulo Neto</a>
</p>
