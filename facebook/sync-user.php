<?php require('../twitter-login.php'); ?>
<h1>Do you already have an account on Mentaway?</h1>

<a href='<?php echo $twitter_url ?>' id="twitter-login" class="redirect">
	<img src='../images/sign-in-with-twitter-d.png'/>
</a>	

<div id="old-account">
	botao do twitter
	
</div>

<div id="new-account">
<!--
	TODO faz um novo request passando service/?new-user criando automaticamente o user e ja liberando os servicos...
-->
</div>

<?php
/*
	TODO
		1. Pergunta pro user se ele ja tem uma conta no mentaway
		2. mostra o bt do twitter para login
		3. depois do login twitter pega o user e adiciona o servico do facebook gravando o token e user_id
		4. Pega todos os friends do facebook e twitter do cara e procura no mentaway, se achar adiciona no friends do user
		5. escreve no wall e twitter do user que ele comecou a usar o mentaway e passa um link google para a app.
		6. pergunta se ele não quer convidar os amigos para usar vi fb para ir pro notifications.
		
		* quando cria um user novo adicionar ele como amigo tanto no novo user como no amigo dele...
		*ex: gisele é nova usuaria e é amiga do eduardo entao a gisele segue o eduardo e o eduardo automaticamente segue ela tb.

*/

?>