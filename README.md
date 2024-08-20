# API RESTful para Geração de Carnês

Este projeto consiste em uma API RESTful desenvolvida em Laravel para gerar e apresentar as parcelas de um carnê. A API recebe o valor total, quantidade de parcelas, primeiro dia de cobrança, periodicidade e um possível valor de entrada. Ela retorna o total, valor de entrada (se houver) e as parcelas geradas.

## Funcionalidades

### 1. Criação de um Carnê

**Endpoint:** `POST /api/carne`

**Parâmetros:**

- `valor_total` (float): O valor total do carnê.
- `qtd_parcelas` (int): A quantidade de parcelas.
- `data_primeiro_vencimento` (string, formato YYYY-MM-DD): A data do primeiro vencimento.
- `periodicidade` (string, valores possíveis: "mensal", "semanal"): A periodicidade das parcelas.
- `valor_entrada` (float, opcional): O valor da entrada.

**Resposta em JSON:**

```json
{
  "total": 100.00,
  "valor_entrada": 0.00,
  "parcelas": [
    {
      "data_vencimento": "2024-08-01",
      "valor": 8.33,
      "numero": 1
    },
    {
      "data_vencimento": "2024-09-01",
      "valor": 8.33,
      "numero": 2
    },
    ...
  ]
}

## Instalação
Requisitos
PHP >= 8.0
Composer
Laravel 9.x



# Passos para Instalação
Clone o repositório:

git clone https://github.com/seu-usuario/seu-projeto.git
cd seu-projeto
Instale as dependências:

composer install

## Testes
Testando com Postman ou Insomnia
Criar um Carnê:

Método: POST

URL: http://localhost:8000/api/carne

Corpo da requisição (JSON):

json

{
  "valor_total": 100.00,
  "qtd_parcelas": 12,
  "data_primeiro_vencimento": "2024-08-01",
  "periodicidade": "mensal"
}
Recuperar Parcelas de um Carnê:

Método: GET
URL: http://localhost:8000/api/carne/{id}
