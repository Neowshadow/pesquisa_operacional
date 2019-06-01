class Variavel {
	constructor(val,peso){
		this._valor=Number(val);
		this._peso=Number(peso);
	}
	get valor(){
		return this._valor;
	}
	
	set valor(val){
		this._valor=Number(val);
	}
	
	get peso(){
		return this._peso;
	}
	
	set peso(val){
		this._peso=Number(val);
	}
}

// function knapsack(tamanho,pesos,valores){
function knapsack(tamanho,vars){
	n = Number(vars.length);
	tamanho=Number(tamanho);
	knap = Array();
	// p = pesos.map(function(x){
		// return Number(x);
	// });
	// v = valores.map(function(x){
		// return Number(x);
	// });
	p = vars.map(function(x){
		return Number(x.peso);
	});
	v = vars.map(function(x){
		return Number(x.valor);
	});
	for(var i=0;i<n+1;i++){
		var aux = Array();
		for(var j=0;j<tamanho+1;j++){
			aux.push(0);
		}
		knap.push(aux);
	}
	
	for(var i=0;i<n+1;i++){
		for(var w=0;w<tamanho+1;w++){
			if(i==0 || w==0){
				knap[i][w]=0;
			}
			else if(p[i-1] <= w){
				knap[i][w]=Math.max(v[i-1] + knap[i-1][w-p[i-1]],knap[i-1][w]);
				//console.log(v[i-1],knap[i-1][w-p[i-1]],knap[i-1][w]);
				//console.log(i-1,w-p[i-1],w,p[i-1]);
			}
			else{
				knap[i][w]= knap[i-1][w];
			}
		}
	}
	// console.log(knap);
	return {'r':knap[n][tamanho],'tb':knap};
}

