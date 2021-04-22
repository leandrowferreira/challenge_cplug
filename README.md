# Teste de seleção para desenvolvedor PHP

Esse teste é dividido em 5 exercícios.

Serão analisados:
 - Estrutura, código organizado e limpo
 - Conceitos SOLID
 - Uso dos recursos do Laravel

# Instruções

O projeto esta foi feito em Laravel e banco de dados MySql.

    composer install

    php artisan migrate

# Exercícios

## 01 - Clientes

 - Refatorar o método *CustomerController@store* 
 - Implementar o método *CustomerController@update*

Fique livre para fazer **qualquer alteração** no projeto (exceto nos testes unitários que devem executar com sucesso):

    php artisan test --filter=CustomerTest

## 02 - Cálculo de parcelas

Corrigir o bug no cálculo do valor das parcelas da rota /api/payment/calculate descrito no teste:

    php artisan test --filter=PaymentTest

## 03 - Consumo de API

Implementar uma API (adicionar rota, criar o controller, etc) que receba um tipo de cryptmoeda, a data de compra e a data de venda. E que retorne o valor pago, vendido e o lucro. Conforme descrito no tests/Feature/ApiTest.php

Para o valor utilizar o preço médio do dia segundo a API Pública [https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary](https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary)

    php artisan test --filter=ApiTest

## 04 - Filtro por hora
## 05 - Modelagem de Produtos com Atributos

Criar os migrates com as tabelas necessárias para armazenar produtos que possuem atributos. Exemplos:
    - Camiseta da seleção brasileira
        - Tamanho: P, M, G e GG
    - Chuteira da Nike
        - Tamanho: 36, 38, 40, 42
        - Cores: Azul, Vermelho, Verde, Rosa

Deverá ser possível armazenar o **preço** e a **quantidade** em estoque de cada item.
