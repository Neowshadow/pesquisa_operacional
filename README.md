# Projeto Simplex

##Classe Simplex:
	###M�todos:
		addRestricao(...) //parametros opcionais. Pode-se iniciar uma restri��o com valores do multiplicando de acordo com a ordem dos parametros. Se houver uma quantidade de parametros igual � quantidade de variaveis + 1(do resultado), atribui ao resultado o ultimo parametro. Retorna um objeto de Restricao.
		
		removeRestricao(index) //remove a Restricao no index indicado. Retorna TRUE ou FALSE
		
		setRestricao(index,resultado,...) //atribui � restri��o no index indicado o resultado e nas variaveis dela, os valores parametrizados. Exemplo: setRestricao(0,100,1,5,6) -- Restricao[0] -> 1 x1 + 5 x2 + 6 x3 <= 100
		
		addVariavel(nome,val) //cria uma variavel na fun��o e em todas restri��es. Parametro val opcional (valor da variavel � 0 por padr�o). Retorna TRUE ou FALSE
		
		removeVariavel(index ou nome) //remove a variavel do index (ou de nome) indicado na fun��o e nas restri��es.
		
		setNomeVariavel(nome,index) //atribui � variavel do index indicado na fun��o e nas restri��es o nome parametrizado
		
		setValorVariavelFuncao(valor, index ou nome) //atribui � variavel do index ou do nome indicado o valor parametrizado
		