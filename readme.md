# API de comentários em postagens

Projeto de teste para a implementação de uma API desenvolvida em PHP com Laravel 5.5


#Front end
Tomei a liberdade de também desenvolver uma parte visual para aplicação, facilitando a criação de dados para a API.

Para poder administrar também os usuários o usuário deve ser administrador. Alterar o campo "role" da tabela users para 1, para criar o primeiro administrador, que poderá criar outros.

# Endpoints  API

#####localhost/public/api/postagem/{id_da_postagem}/comentarios  -> tipo GET

Lista todos os comentários de uma postagem específica, determinada pelo ID, ordenada da mais nova para a mais antiga.

Este endpoint suporta paginação. Para acessar as próximas páginas é necessário adicionar ao final da URL o parametro:
 
 "?page=(numero da página)" 
 
 Este endpoint retorna:
 
 a. id do usuário
 b. id do comentário
 c. login
 d. assinante
 e. data/hora
 f. comentário
 
#####localhost/public/api/usuario/{id_do_usuário}/notificacoes -> tipo GET

Lista todas as notificações do usuário determinado pelo ID. 

Após ser mostrada pela primeira vez, ou listada na API a notificação deve ser exibida apenas por mais 6 horas (número puramente arbitrário)

#####localhost/public/api/postagem/comentar -> tipo POST

Endpoint que insere um novo comentário a uma postagem.

Para que seja possível a insersão, os dados de login e senha.

Parâmetros:

1. "post_id" (ID da postagem que será comentada) ;
2. "comment" (Texto do comentário à ser inserido);

Caso o usuário da postagem e o usuário do comentário não sejam assinantes, e o usuário do comentário não esteja comprando destaque, o comentário não deve ser realizado.

Um usuário pode comentar uma vez a cada 30 segundos pelo menos, ou então seu comentário também não será inserido.


####Se houverem quaisquer dúvidas, estou à disposição no email: gtkanal@gmail.com
