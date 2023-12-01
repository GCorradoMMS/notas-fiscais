# Notas Fiscais

API para operações CRUD envolvendo notas fiscais.


# Dependências

- PHP >= 8.2
- Composer
- NPM

# Instalação
- Configurar banco de dados  `notas_fiscais` no arquivo `.env`
- Configurar `smtp` no arquivo `.env` (mailtrap recomendado)
- Rodar comandos `composer update` e `composer install`
- Rodar comando `php artisan migrate`
- Rodar comando `php artisan queue:work`


# Observações
 - Github Actions habilitado para testes.
 - VerifyCSRFToken removido para facilitar desenvolvimento em localhost
 - SoftDelete utilizado nas tabelas das notas fiscais (a nota não é excluída por completo, mas é adicionado a data do delete e não aparece mais nas requisições)
