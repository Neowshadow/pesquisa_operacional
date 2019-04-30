# Projeto Simplex

##Classe Simplex:
	###Métodos:
		addRestricao(...) //parametros opcionais. Pode-se iniciar uma restrição com valores do multiplicando de acordo com a ordem dos parametros. Se houver uma quantidade de parametros igual à quantidade de variaveis + 1(do resultado), atribui ao resultado o ultimo parametro. Retorna um objeto de Restricao.
		
		removeRestricao(index) //remove a Restricao no index indicado. Retorna TRUE ou FALSE
		
		setRestricao(index,resultado,...) //atribui à restrição no index indicado o resultado e nas variaveis dela, os valores parametrizados. Exemplo: setRestricao(0,100,1,5,6) -- Restricao[0] -> 1 x1 + 5 x2 + 6 x3 <= 100
		
		addVariavel(nome,val) //cria uma variavel na função e em todas restrições. Parametro val opcional (valor da variavel é 0 por padrão). Retorna TRUE ou FALSE
		
		removeVariavel(index ou nome) //remove a variavel do index (ou de nome) indicado na função e nas restrições.
		
		setNomeVariavel(nome,index) //atribui à variavel do index indicado na função e nas restrições o nome parametrizado
		
		setValorVariavelFuncao(valor, index ou nome) //atribui à variavel do index ou do nome indicado o valor parametrizado
		