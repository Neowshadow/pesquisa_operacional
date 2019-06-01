# Projeto Simplex

## Classe Simplex:
 ... - n parametros
 
addRestricao(...) //parametros opcionais. Pode-se iniciar uma restrição com valores do multiplicando de acordo com a ordem dos parametros. Se houver uma quantidade de parametros igual à quantidade de variaveis + 1(do resultado), atribui ao resultado o ultimo parametro. Retorna um objeto de Restricao.
Exemplo: addRestricao(5,7,1,90) -- nova Restricao -> 5 x1 + 7 x2 + 1 x3 <= 90

removeRestricao(index) //remove a Restricao no index indicado. Retorna TRUE ou FALSE

setRestricao(index,...) //atribui à restrição no index indicado, o resultado e as variaveis recebem os valores.
Exemplo: setRestricao(0,1,5,6,100) -- Restricao[0] -> 1 x1 + 5 x2 + 6 x3 <= 100

addVariavel(nome,val) //cria uma variavel na função e em todas restrições. Parametro val opcional (valor da variavel é 0 por padrão). Retorna TRUE ou FALSE

removeVariavel(index ou nome) //remove a variavel do index (ou de nome) indicado na função e nas restrições. Retorna TRUE ou FALSE

setNomeVariavel(nome,index) //atribui à variavel do index indicado na função e nas restrições o nome

setFuncao(...) //atribui às variaveis da função objetiva os valores passados nos parametros.
Exemplo: setFuncao(3,4,1) -- Z = 3 x1 + 4 x2 + 1 x3

execute(numero maximo de iteracoes , minimizar) // opcao por padrão é maximizar, colocar true (ou 1) no segundo parametro para minimizar. Retorna um objeto com todos as tabelas e passos.