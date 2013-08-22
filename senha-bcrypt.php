<?php
	/*Criptografia*/
	 
	$password = 'ola mundo';
	$custo = '08';
	$salt = 'Cf1f11ePArKlBJomM0F6aJ';
	 
	// Gera um hash baseado em bcrypt
	$hash = crypt($password, '$2a$' . $custo . '$' . $salt . '$');

	//isso no vai gerar o seguinte hash:
	//$2a$08$Cf1f11ePArKlBJomM0F6a.EyvTNh6W2huyQi5UZst5qsHVyi3w5x.

	/*Verificando e validando senhas usando bcrypt*/

	/*tela de validação*/
	 
	// Senha digitada pelo usuário (veio do formulário)
	$password = 'ola mundo';
	 
	// Senha já criptografada (salva no banco)
	$hash = '$2a$08$Cf1f11ePArKlBJomM0F6a.EyvTNh6W2huyQi5UZst5qsHVyi3w5x.';
	 
	if (crypt($password, $hash) === $hash) {
		echo 'Senha OK!';
	} else {
		echo 'Senha incorreta!';
	}
	// classe to TiuTalk
	//https://gist.github.com/TiuTalk/3438461
?>