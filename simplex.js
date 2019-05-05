//////////////////Variavel////////////////////
class Variavel{
	constructor(nome,valor){
		this._nome = nome;
		if(typeof valor == "number")
			this._valor = valor;
		else
			this._valor = 0;
	}
	get nome(){
		return this._nome;
	}
	set nome(val){
		this._nome = val;
	}
	
	get valor(){
		return this._valor;
	}
	set valor(val){
		this._valor = val;
	}
};
//////////////////////////////////////////////

//////////////////Funcao//////////////////////
class Funcao{
	constructor(){
		this._variaveis = new Array(new Variavel('x1'));
		this._result = 0;
	}
	get variaveis(){
		return this._variaveis;
	}
	set result(val){
		if(!isNaN(Number(val))){
			this._result = Number(val);
		}
	}
	get result(){
		return this._result;
	}
}
Funcao.prototype.addVariavel = function(nome,val){
	var safeToaddVariavel = true;
	this._variaveis.forEach(function(item){
		if(nome === item.nome) safeToaddVariavel = false;
	});
	if(safeToaddVariavel){
		var aux = new Variavel(nome,val);
		this._variaveis.push(aux);
	}
	return aux;
}
Funcao.prototype.removeVariavel = function(index){
	if(this._variaveis.splice(index,1)!=[]) return true;
	return false
}
Funcao.prototype.setNome = function(nome,index){
	this.variaveis[index].nome = nome;
}
Funcao.prototype.setValor = function(val,indexOuNome){
	if(!isNaN(indexOuNome)){
		if(indexOuNome<this._variaveis.length){
			this._variaveis[indexOuNome].valor = val;
			return true;
		}
	}
	else for(i in this._variaveis){
		if(this._variaveis[i].nome == indexOuNome){
			this._variaveis[i].valor = val;
			return true;
		}
	}
	return false;
}
Funcao.prototype.check = function(){ //checagem utilizada durante a execução do algoritmo de simplex
	var aux = false;
	for(var i in this._variaveis){
		if(this._variaveis[i].valor>0) aux = true;
	}
	return aux;
}
//////////////////////////////////////////////

//////////////////Restricao///////////////////
class Restricao{
	constructor(vars,result){
		this._variaveis = [];
		this._result = result || 0;
		this._nome = '';
		if(vars != undefined){
			vars.forEach(function(item,idx){
				this._variaveis.push(new Variavel(item.nome));
			}.bind(this));
		}
	}
	get variaveis(){
		return this._variaveis;
	}
	get restricoes(){
		return this._result;
	}
	set result(val){
		if(!isNaN(Number(val))){
			this._result = Number(val);
			return true
		}
		return false;
	}
	get result(){
		return this._result;
	}
	
	set nome(val){
		if(typeof val == 'string')
			this._nome = val;
	}
	get nome(){
		return this._nome;
	}
}
Restricao.prototype.addVariavel = function(nome,val){
	var safeToaddVariavel = true;
	this._variaveis.forEach(function(item){
		if(nome === item.nome) safeToaddVariavel = false;
	});
	if(safeToaddVariavel) this._variaveis.push(new Variavel(nome,val));
  return safeToaddVariavel;
};
Restricao.prototype.removeVariavel = function(index){
	return this._variaveis.splice(index,1);
}
Restricao.prototype.setNomeVariavel = function(nome,index){
	this.variaveis[index].nome=nome;
}
Restricao.prototype.setValor = function(val,indexOuNome){
	if(!isNaN(indexOuNome)){
		if(indexOuNome < this._variaveis.length)
			this._variaveis[indexOuNome].valor = Number(val);
	}
	else for(i in this._variaveis){
		if(this._variaveis[i].nome == indexOuNome){
			this._variaveis[i].valor = val;
			return true;
		}
	}
	return false;
}
//////////////////////////////////////////////

//////////////////Simplex/////////////////////
class Simplex{
	constructor(){
		this.funcao = new Funcao();
		this.restricoes = [new Restricao(this.funcao.variaveis)];
		this._maxIteracao = 10;
	}
	get maxIteracao(){
		return this._maxIteracao;
	}
	set maxIteracao(val){
		this._maxIteracao = val;
	}
}
Simplex.prototype.addRestricao = function(...args){
	var aux = new Restricao(this.funcao.variaveis);
	this.restricoes.push(aux);
	for(i in arguments){
		if(i==this.funcao.variaveis.length){
			aux.result = arguments[i];
			break;
		}
		aux.setValor(arguments[i],i);
	}
	return aux;
}
Simplex.prototype.removeRestricao = function(idx){
	var aux = this.restricoes.splice(idx,1);
	return aux[0] instanceof Restricao;
}
Simplex.prototype.addVariavel = function(nome,val){
	if(this.funcao.addVariavel(nome,val)){
		this.restricoes.forEach(function(item,idx){
			item.addVariavel(nome);
		});
		return true;
	}
	return false;
}
Simplex.prototype.removeVariavel = function(idxOuNome){
	var aux = idxOuNome;
	if(Number(aux)<this.funcao.variaveis.length){
		if(this.funcao.removeVariavel(Number(aux))){
			this.restricoes.forEach(function(item){
				item.removeVariavel(Number(aux));
			});
			return true;
		}
	}else{
		for(var i in this.funcao.variaveis){
			if(this.funcao.variaveis[i].nome==aux){
				this.funcao.removeVariavel(i);
				this.restricoes.forEach(function(item){
					item.removeVariavel(i);
				});
				return true;
			}
		}
	}
	return false;
}
Simplex.prototype.setNomeVariavel = function(nome,idx){
	this.funcao.setNome(nome,idx);
	for(var item in this.restricoes){
		this.restricoes[item].setNomeVariavel(nome,idx);
	}
}
Simplex.prototype.setValorVariavelFuncao = function(val,idxOuNome){
	return this.funcao.setValor(val,idxOuNome);
}
Simplex.prototype.setFuncao = function(...args){
	var aux = 0;
	for(let i of args){
		this.funcao.variaveis[aux++].valor = i;
		if(aux==this.funcao.variaveis.length) break;
	}
}
Simplex.prototype.setValorVariavelRestricao = function(val,idxOuNome,rest){
	return this.restricoes[rest].setValor(val,idxOuNome);
}
Simplex.prototype.setResultRestricao = function(val,rest){
	if(rest<this.restricoes.length)
		this.restricoes[rest].result = val;
}
Simplex.prototype.setRestricao = function(index,...rest){
	var aux = 0;
	for(let i of rest){
		if(aux==this.funcao.variaveis.length){
			this.restricoes[index].result = i;
			break;
		}
		this.restricoes[index].setValor(i,aux++);
	}
}
Simplex.prototype.execute = function(iteracao,opcao){
	var fo = this.funcao;
	var re = this.restricoes;
	var display = {};
	if(typeof iteracao == 'number')
		fo.maxIteracao = iteracao;
	if(opcao){
		fo.variaveis.forEach(function(item){
			item.valor = -item.valor;
		});
	}
	
	//display inicial, mostrando funcao objetiva e restricoes
	display['inicio'] = {};
	display['inicio']['z'] = '';
	for(var item in fo.variaveis){
		display['inicio']['z']+=fo.variaveis[item].valor+fo.variaveis[item].nome;
		if(item<fo.variaveis.length-1) display['inicio']['z']+= ' + ';
	}
	display['inicio'].restricoes = [];
	var inicio = display.inicio;
	for(var linha in re){
		var antes = {};
		var depois = {};
		inicio.restricoes[linha] = {};
		re[linha].variaveis.forEach(function (item,index){
			antes[item.nome] = item.valor;
			depois[item.nome] = item.valor;
		});
		antes.result = re[linha].result;
		inicio.restricoes[linha].antes = antes;
		inicio.restricoes[linha].depois = depois;
	}
	
	// console.log(display);
	
	//primeiro passo - adicionar variaveis de folga.
	for(var item in re){
		var displayRestricao = inicio.restricoes[item];
		fo.addVariavel('F'+item,0);
		for(var aux in re){
			re[aux].addVariavel('F'+item,0);
		}
		re[item].nome='F'+item;
		var pos = re[item].variaveis.length-1;
		re[item].setValor(1,pos);
		displayRestricao.depois[re[item].nome]=re[item].variaveis[pos].valor;
		displayRestricao.depois.result = re[item].result;
	}
	
	display.iteracao = []
	display.iteracao[0] = {tabela:[],pivo:{}};
	var tabela = display.iteracao[0].tabela;
	for(var i in re){
		var linha = re[i];
		tabela[i] = {};
		tabela[i].base = linha.nome;
		for(var item in linha.variaveis){
			tabela[i][linha.variaveis[item].nome] = linha.variaveis[item].valor;
		}
		tabela[i].b = linha.result;
	}
	tabela.push({});
	tabela[tabela.length-1].base = 'Z';
	for(var item in fo.variaveis){
		tabela[tabela.length-1][fo.variaveis[item].nome]= 0-(fo.variaveis[item].valor);
	}
	tabela[tabela.length-1].b = fo.result;
	
	
	
	for(var count = 1;iteracao>0 && fo.check();iteracao--,count++){
	//console.log('passo 2');
	//segundo passo - da funcao objetiva, pegar a variavel de maior valor (apresentando na tabela como valor negativo)
	var highest = 0;
	var coluna = -1;
	for(var item in fo.variaveis){
		if(fo.variaveis[item].valor>highest){
			highest = fo.variaveis[item].valor;
			coluna = item;
		}
	}
	
	if(coluna>-1){
	
	//terceiro passo - achar pivô (resultado/variavel[coluna_restricao])->menor valor positivo
	var lowest = Number.MAX_SAFE_INTEGER;
	var linha = -1;
	for(var item in re){
		
		if(re[item].result / re[item].variaveis[coluna].valor<lowest){
			lowest = re[item].result / re[item].variaveis[coluna].valor;
			linha = item;
		}
	}
	if(linha == -1) break;
	// console.log(display.iteracao);
	display.iteracao[count-1].pivo = {'linha':re[linha].nome,'coluna':re[linha].variaveis[coluna].nome};
	var pivo = re[linha].variaveis[coluna].valor;
	//variavel da linha do pivo sai da base e entra a variavel da coluna do pivo
	re[linha].nome = re[linha].variaveis[coluna].nome;
	
	//quarto passo - dividir a linha do pivo pelo proprio pivo (para deixar o pivo = 1)
	for(var item in re[linha].variaveis){
		re[linha].variaveis[item].valor /= pivo;
	}
	re[linha].result /= pivo;
	//quinto passo - utilizar a linha do pivo para zerar os valores da coluna do pivodas outras restrições, assim como o da funcao objetiva
	for(var i in re){
		if(re[i]!=re[linha]){
			var aux = re[i];
			var val = aux.variaveis[coluna].valor;
			for(var j in re[i].variaveis){
				aux.variaveis[j].valor -= re[linha].variaveis[j].valor * val;
			}
			
			aux.result -= re[linha].result*val;
		}
	}
	var val = fo.variaveis[coluna].valor;
	for(var item in fo.variaveis){
		fo.variaveis[item].valor -= re[linha].variaveis[item].valor * val;
	}
	fo.result -= re[linha].result*val;
	
	//gerando tabela
	display.iteracao[count] = {tabela:[],pivo:{}};
	tabela = display.iteracao[count].tabela;
	for(var i in re){
		var linha = re[i];
		tabela[i] = {};
		tabela[i].base = linha.nome;
		for(var item in linha.variaveis){
			tabela[i][linha.variaveis[item].nome] = linha.variaveis[item].valor;
		}
	}
	tabela.push({});
	tabela[tabela.length-1].base = 'Z';
	for(var item in fo.variaveis){
		tabela[tabela.length-1][fo.variaveis[item].nome]= 0	-(fo.variaveis[item].valor);
	}
	tabela[tabela.length-1].b = fo.result;
	
	//console.log(display);
	
	// retorna para segundo passo
	}
	}
	return display;
}
//////////////////////////////////////////////



function btnAddRestricao(){
	var restricao = s.addRestricao();
	//console.log(s);
	updateRestricao(restricao,s.restricoes.length-1);
}
function btnRemoveRestricao(val){
	s.removeRestricao(val);
	//console.log(s);
}
function btnExecute(){
	//executa o metodo simplex com no maximo x iterações
	res = s.execute(100);
	//console.log(s);
	
	//geracao da tabela
	var head = document.getElementsByTagName('thead');
	var body = document.getElementsByTagName('tbody');
	
	var base = document.createElement('th');
	var b = document.createElement('th');
	base.innerText = 'Base';
	b.innerText = 'b';
	head[0].appendChild(base);
	
	s.funcao.variaveis.forEach(function(item){
		var aux = document.createElement('th');
		aux.innerText = item.nome;
		head[0].appendChild(aux);
	});
	head[0].appendChild(b);
	
	s.restricoes.forEach(function(item){
		var row = document.createElement('tr');
		var aux = document.createElement('td');
		aux.innerText = item.nome;
		body[0].appendChild(row);
		row.appendChild(aux);
		item.variaveis.forEach(function(fn){
			var cell = document.createElement('td');
			cell.innerText = (fn.valor).toFixed(3);
			row.appendChild(cell);
		});
		var cell = document.createElement('td');
		cell.innerText = (item.result).toFixed(3);
		row.appendChild(cell);
	});
	var row = document.createElement('tr');
	var z = document.createElement('td');
	body[0].appendChild(row);
	row.appendChild(z);
	z.innerText = 'Z';
	var list = s.funcao.variaveis;
	list.forEach(function(fn){
		var cell = document.createElement('td');
		cell.innerText = (-fn.valor).toFixed(3);
		row.appendChild(cell);
	});
	var cell = document.createElement('td');
	cell.innerText = (-s.funcao.result).toFixed(3);
	row.appendChild(cell);
}

function updateRestricao(restricao,idx){
	var line = document.createElement('div');
		line.className='res';
		line.id='f'+idx+1;
		document.getElementById('restricoes').appendChild(line);
		//console.log(restricao);
		for(item in restricao.variaveis){
			//	console.log(item);
			var aux = document.createElement('span');
			aux.className = 'vd ';
			aux.innerText = restricao.variaveis[item].valor+' '+restricao.variaveis[item].nome;
			line.appendChild(aux);
		}
		var result = document.createElement('span');
		result.className = 'result';
		result.innerText = restricao.result;
		line.appendChild(result);
		var button = document.createElement('button');
		button.innerText = 'Remove Restricao';
		button.addEventListener('click', function(e){
			btnRemoveRestricao(idx);
			line.parentNode.removeChild(line);
		});
		line.appendChild(button);
}
//////////////////////////////////////////////


//////////////////Testing/////////////////////
	var s = new Simplex();
// teste 1
	/*s.setValorVariavelFuncao(11,0);
	s.addVariavel('x2',12);
	s.addRestricao();
	
	s.setValorVariavelRestricao(4,1,0);
	s.setValorVariavelRestricao(5,0,1);
	s.setValorVariavelRestricao(2,1,1);
	s.setResultRestricao(10000,0);
	s.setResultRestricao(30000,1);*/
	
	
// teste 2
	s.setValorVariavelFuncao(10,0);
	s.addVariavel('x2',6);
	s.addVariavel('x3',4);
	
	// s.setResultRestricao(100,0);
	s.addRestricao();
	// s.setValorVariavelRestricao(10,0,1);
	// s.setValorVariavelRestricao(4,1,1);
	// s.setValorVariavelRestricao(5,2,1);
	// s.setResultRestricao(600,1);
	s.addRestricao();
	// s.setValorVariavelRestricao(2,0,2);
	// s.setValorVariavelRestricao(2,1,2);
	// s.setValorVariavelRestricao(6,2,2);
	// s.setResultRestricao(300,2);
	s.setRestricao(0,1,1,1,100);
	s.setRestricao(1,10,4,5,600);
	s.setRestricao(2,2,2,6,300);
	
//apresenta valores definidos acima nas divs
	document.getElementById('test').innerText = 'Z = ';
	s.funcao.variaveis.forEach(function(item){
		var aux = document.createElement('span');
		aux.className = 'vd ';
		aux.innerText = item.valor+' '+item.nome;
		document.getElementById('test').appendChild(aux);
	});
	

	s.restricoes.forEach(updateRestricao);
