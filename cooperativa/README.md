# Sistema Cooperativa - Produtores e Comércio Local

Este sistema foi desenvolvido para a cooperativa dos produtores rurais do município de Caratinga/MG, permitindo que produtores cadastrem seus produtos, a cooperativa cadastre estabelecimentos comerciais, e consumidores encontrem os produtos disponíveis em diferentes locais da cidade.

## Requisitos

- PHP 7.4 ou superior  
- Servidor Web (Apache, Nginx, etc) com suporte a PHP  
- MySQL ou MariaDB  
- Extensão PDO para PHP habilitada  
- Permissão para upload de arquivos no servidor (diretório `uploads/`)


## Instalação

1. Clone ou extraia os arquivos do projeto para a pasta pública do servidor (`www` ou `htdocs`).  
2. Importe o banco de dados SQL fornecido (`database/cooperativa.sql`) no seu MySQL:  
3. Configure o acesso a manipulação de dados (`config/database.php`)

## O sistema possui três tipos de usuários:

1. Produtor: pode cadastrar seus produtos, incluindo fotos descrição e valor.

2. Comerciante: cadastra seus estabelecimentos comerciais, incluindo foto da fachada, endereço e descrição. Além de aceitar ou não as solicitações que os produtores fazem para vender seus produtos em seu estabelecimento

3. Consumidor Final: pode navegar e visualizar os estabelecimentos e produtos disponíveis, adicionar produtos ao carrinho e finalizar compras.

### Funcionalidades Respectivas

## Produtor
1. Cadastro/Edição/Exclusão de seus produtos ofertados
2. Caso um produto ofertado seja excluido e o mesmo está ativo em algum comercio, o mesmo não será mais ofertado pelo comerciante
3. Vincular seus produtos a estabelecimentos cadastrados
4. Alterar seus dados de usuario (nome, email, senha...)

## Comerciante
1. Cadastro/Edição/Exclusão de seus comercios com Fachada, foto e endereço
2. Possibilidade de Aceitar ou Não as solicitações que os produtores o faz para que vinculem a seu comercio
3. Remover um produto já ativo em seu comercio. Mesmo que o produtor não o tenha excluido, simplesmente deixa de existir o vinculo
4. Alterar seus dados de usuario (nome, email, senha...)

## Consumidor Final
1. Não precisa de Login na aplicação
2. Consegue ver uma lista de todos os produtos ofertados
3. Consegue ver uma lista de todos os comercios da cidade
4. Carrinho que salva os dados por sessão, uma vez que o consumidor final não possui um banco de dados proprio

## importante: Se um produtor criar um novo produto, o comerciante precisa **aceitar** a solicitação para que o produto fique ativo e apareça na lista de ofertas para o cliente final.

