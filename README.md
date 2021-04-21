# Teste de seleção para desenvolvedor PHP

Esse teste é dividido em X questões.

# Instruções

O projeto esta foi feito em Laravel e banco de dados MySql.

    composer install
    php artisan migrate

# Exercícios

## 01 - Clientes

 - Refatorar o método *CustomerController@store* 
 - Implementar o método *CustomerController@update*

Fique livre para fazer qualquer alteração no CustomerController desde que o teste automatizado execute com sucesso:

    php artisan test --filter=CustomerTest

## 02 - Cálculo de parcelas
## 03 - Consumo de API
## 04 - Filtro por hora
## 05 - Modelagem de Produtos com Atributos

Criar os migrates com as tabelas necessárias para armazenar produtos que possuem atributos. Exemplos:
- Camiseta da seleção brasileira
    - Tamanho: P, M, G e GG
- Chuteira da Nike
    - Tamanho: 36, 38, 40, 42
    - Cores: Azul, Vermelho, Verde, Rosa

Deverá ser possível armazenar o **preço** e a **quantidade** em estoque de cada item.
