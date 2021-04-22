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

Podem ser adicionados outros métodos nos arquivos de teste porém os que existem não podem ser modificados. E o objetivo final é executar todos os testes existentes com sucesso.

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

Implementar uma API (adicionar rota, criar o controller, etc) que receba um tipo de cryptmoeda, a data de compra e a data de venda. E que retorne o valor pago, vendido e o lucro. Conforme descrito no [tests/Feature/ApiTest.php]

Para o valor utilizar o preço médio do dia segundo a API Pública [https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary](https://www.mercadobitcoin.com.br/api-doc/#method_trade_api_daysummary)

Exemplo de saída:

    {
    "valor_da_compra": 10513.88,
    "valor_da_venda": 46656.85,
    "lucro": 36144.97,
    "lucro_percentual": 343.78,
    "intervalo_em_dias": 76
    }

Teste que deve executar:

    php artisan test --filter=ApiTest

## 04 - Filtro por hora

Dado dois intervalos de horarios, o primeiro é o horário desejado e o outro o que já está ocupado. Ex:

    //escolhido das 07h as 08h
    $selected = ['start' => '07:00', 'end' => '08:00'];

    //ja esta reservado das 09h as 10h
    $blocked = ['start' => '09:00', 'end' => '10:00'];

    //nesse exemplo podemos fazer a reserva pois o intervalo das 7 as 8h está livre

Implementar a lógica do método SchedulerTest@isBusy para que o SchedulerTest seja válido

    php artisan test --filter=SchedulerTest

## 05 - Modelagem de Produtos com Atributos

Criar os migrates com as tabelas necessárias para armazenar produtos que possuem atributos. Exemplos:

 - Camiseta da seleção brasileira
  - Tamanho: P, M, G e GG
 - Chuteira da Nike
  - Tamanho: 36, 38, 40, 42
  - Cores: Azul, Vermelho, Verde, Rosa

Deverá ser possível armazenar o **preço** e a **quantidade** em estoque de cada item.
