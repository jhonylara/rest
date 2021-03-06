# Propriedades da aplicação

Este foi um projeto com um servidor rest em codeigniter 3, com um client em Vue.js e axios juntamente com banco de dados MySQL.

- Foi um projeto rápido, nunca tive contato com Vue.js e axios, e muito pouco com aplicações rest, provavelmente não segui o framework padrão do vue.
- Tive muitas dificuldades com a elaboração do client, devido a inexperiência, e não saber oque ele é capaz de fazer.
- Estou satisfeito com o resultado, é uma aplicação funcional (Mesmo com todos os remendos) mostrou que sou capaz de me superar.

## Configurações do ambiente

Baixar o projeto do repositório ou zip e colocar na pasta no servidor ex.: (wamp, /www)

Criar o banco de dados no MySQL com o script abaixo:

    CREATE DATABASE restful;

    USE restful;

    CREATE TABLE `Usuario`(
      `id` INT(10) NOT NULL auto_increment  KEY,
      `email` VARCHAR(50) UNIQUE,
        `username` VARCHAR(30) UNIQUE,
        `senha` VARCHAR(100) NOT NULL,
        `nome` VARCHAR(30) NOT NULL,
        `data_criacao` datetime NOT NULL
    );

    select * from Usuario;

    INSERT INTO Usuario (email, username, senha, nome, data_criacao)
    VALUES ('administrador@admin.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrador', now());

    INSERT INTO Usuario (email, username, senha, nome, data_criacao)
    VALUES ('usuario@user.com', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'usuario', now());

Configurar o codeigniter para acessar o banco:

`
rest/application/config/database.php
`

    'hostname' => 'localhost', - endereço do banco
    'username' => 'admin', - usuario
    'password' => 'admin', - senha
    'database' => 'restful', - database
    'dbdriver' => 'mysqli', - driver padrao


#### Caso o endereço não seja o localhost padrão, ou foi criado um virtual host para o servidor altere TODAS AS FUNÇÕES no arquivo  `rest/front.js` conforme abaixo:

Exemplo padrao

`
    EX: axios.post("http://localhost/rest/api/usuarios", form_data).then(function(response){
`

Exemplo usando um servidor ou virtual host sem apontar a pasta rest:

`
    EX: axios.post("http://(endereço do servidor)/rest/api/usuarios", form_data).then(function(response){
`

Exemplo caso tenha criado um virtual host apontando a pasta rest:

`
    EX: axios.post("http://(virtual host)/api/usuarios", form_data).then(function(response){
`

#### Caso a configuração tenha sido efetuada com sucesso e os usuarios base foram incluidos, ao acessar o client devera estár listando 2 usuarios

## Utilização

Acessar o link

`
http://localhost/rest/front.html
`

Caso utilize um servidor ou virtual host sem apontar a pasta rest:

`
http://(endereço do servidor)/rest/front.html

`
Caso tenha criado um virtual host apontando a pasta rest:
`

http://(virtual host)/front.html
`

Perfil não autenticado
  - Serão exibidos usuários ocultos 
  - Não é exibida pesquisa
  - Pode cadastrar usuários
  - Pode logar

Logar username = 'user', senha = 'user'
  - Serão exibidos usuários sem ocultar
  - Pode alterar somente ele
  - Pode deletar somente ele, se deletado é deslogado
  - Pode inserir usuários
  - Pode listar por nome ou id

Logar username = 'admin', senha = 'admin'
  - Serão exibidos usuarios sem ocultar
  - Pode alterar todos
  - Pode deletar todos
  - Pode inserir usuários
  - Pode listar por nome ou id


## Teste com postman

Caso queira é possível efetuar testes com o postman.

Importe para o postman o arquivo TesteRestfull.postman_collection que está dentro da pasta rest

Caso a configuração esteja em um lugar diferente do `localhost/rest` configure a url da requisição

`
http://(VIRTUAL HOST OU CAMINHO DO SERVIDOR)/(rest [CASO VH NÃO APONTE A PASTA])/api/usuarios
`

O projeto passa por parâmetro uma chave = "chave" valor = "jhony12ed21d1t14"



## Disposição de itens importantes

-rest

--application

---config

----database.php [database-config]

----rest.php [rest-config]

---controllers

----Api.php [request-route]

---model

----Usuario_model[api-model]

-front.html [front-client]

-front.js [back-client]

-.htaccess [rout-config]

-PROJECT.md [instruções]

-TesteRestfull.postman_collection [json-postman]


### Apontamentos

Não foram feitas validações de formulário, infelizmente não consegui.
Não consegui atualizar componentes devido a isso foi feito em somente uma pagina
Utilizei muitas variáveis do navegador para persistir dados durante a atualização da pagina
Não efetuei a devida autenticação com o rest 
Como não sabia se eu poderia criar outras databases ou campos, segui o escopo proposto e efetuei a solução que achei possível com meus conhecimentos
Os perfis são traçados pelo username "admin", somente ele tem o perfil geral.
Não trabalhei corretamente com o framework vue.js, não tinha conhecimento algum desse modelo de programação
Não consegui usar outros métodos como put com o axios


### Considerações

Agradeço a oportunidade de efetuar esse desafio, é uma maneira de me testar diante de algo novo.
Foi interessante conhecer esta tecnologia, quero muito trabalhar com laravel, vue, angular e afins. Os quais ainda não tive contato
Mesmo com todos remendos, percebi que eu consigo contornar os problemas (Sabendo que não é o correto) e atingir o objetivo final.

### Contato

Autor: Jhony Lara

Data: 13/03/2019

Email: contato@jhonylara.com.br 

       jhony.lara@yahoo.com.br
       
Linkedin: https://www.linkedin.com/in/jhonylara/
