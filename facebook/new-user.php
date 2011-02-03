

<?php
/*
 	1. cria user e seta status como pendente
	2. quando adicionar o primeiro servico pega o token depois de autorizado e procura usuario antigo
	3. se achou user antigo pega o servico facebook do usuario novo e adiciona no antigo 
	4. no antigo remove campos não mais usados como token secret picture etc
	5. remove o usuario com status pendente.
	6. o usuario antigo passa a ser o usuario novo. sincronizado
	
  . colocar todas as contas para status inativo para não ficar atualizando para quem não usa.
	. na classe de update deve verifica se a conta é ativa antes de atualizar os placemarks
 		
 */


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