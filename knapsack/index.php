<head>
<title>
	Pesquisa Operacional JS - Problema da Mochila
</title>
</head>
<body>
<link rel='stylesheet' type='text/css' href='../bootstrap-4.3.1-dist/css/bootstrap.css'></link>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


<div id='main' class='content container'>
	<button class='btn btn-primary' onclick='location.href="../"' style='margin:10px 0px 20px 0px'>Voltar para a Pagina Inicial</button>
	
	<div>
		<div class='row'><h3>Problema da Mochila</h3></div>
		
		<div>
			<div class="input-group mb-1 col-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Capacidade</span>
				</div>
				<input type="number" class="var form-control" id='knapsack' value='0'>
			</div>
			<div style='padding-top:10px'>
				<button class='btn btn-primary' onclick='addVariavel()'>Adicionar Item</button>
				<button class='btn btn-primary' onclick='removeVariavel()'>Remover Item</button>
				<button class='btn btn-primary' onclick='limpa()'>Reset</button>
			</div>
			<hr>
			<table class='table' id='vars'>
				<thead>
					<th>Item</th>
					<th>Valor</th>
					<th>Peso</th>
				</thead>
				<tbody>
					<tr id='x1'>
						<td>x1</td>
						<td><input class='val' type='number'></td>
						<td><input class='peso' type='number'></td>
					</tr>
					<tr id='x2'>
						<td>x2</td>
						<td><input class='val' type='number'></td>
						<td><input class='peso' type='number'></td>
					</tr>
				</tbody>
			</table>
			<div class='col-3'><button class='btn btn-primary' onclick='execute()'>Executar</button></div>
			<div style='padding-top:10px; overflow-x:scroll'>
			<table class='table' id='result'>
				<thead>
				</thead>
				<tbody>
				</tbody>
			</table>
			</div>
			<div id='div-res' style='padding-top:20px;padding-bottom:30px; display:none'>
				<table class='table' id='tb-result'>
					<thead>
						<th>Item na Mochila</th>
						<th>Valor</th>
						<th>Peso</th>
					<thead>
					<tbody>
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script src="knapsack.js"></script>
<script src="../bootstrap-4.3.1-dist/js/bootstrap.js"></script>
<script src="../jquery-3.4.1.min.js"></script>
<script>
function test(){
V = [
	new Variavel(60,10),
	new Variavel(100,20),
	new Variavel(120,30)
]
W=50;
div=document.createElement('div');
K=knapsack(W,V);
console.log(K);

}
<!-- test(); -->

function addVariavel(){
	var last = $('#vars tr').last();
	var id = 'x'+(Number(last.attr('id').substr(1))+1);
	
	var $tr = $('<tr>',{'id':id});
	var $td_var = $('<td>',{'text':id});
	var $td_valor = $('<td>');
	var $td_peso = $('<td>');
	var $input_valor = $('<input>',{'class':'val','type':'number'});
	var $input_peso = $('<input>',{'class':'peso','type':'number'});
	
	$td_valor.append($input_valor);
	$td_peso.append($input_peso);
	$tr.append($td_var,$td_valor,$td_peso);
	
	$('#vars tbody').append($tr);
}

function removeVariavel(){
	var trs = $('#vars tbody tr').length;
	var last = $('#vars tbody tr:last-child');
	
	if(trs>2){
		last.remove();
		return true;
	}
	return false;
}

function limpa(){
	while(removeVariavel());
	var trs = $('#vars tbody tr');
	for(var i=0;i<trs.length;i++){
		trs[i].getElementsByClassName('val')[0].value='';
		trs[i].getElementsByClassName('peso')[0].value='';
	}
	$('#result thead').empty();
	$('#result tbody').empty();
	$('#div-res').hide();
	$('#tb-result tbody').empty();
}

function execute(){
	$('#result thead').empty();
	$('#result tbody').empty();
	$('#tb-result tbody').empty();
	var W = Number($('#knapsack').val());
	var trs = $('#vars tbody tr');
	var V=Array();
	for(var i=0;i<trs.length;i++){
		V.push(new Variavel(
			trs[i].getElementsByClassName('val')[0].value,
			trs[i].getElementsByClassName('peso')[0].value
		));
	}
	var K=knapsack(W,V);
	console.log(V);
	console.log(K);
	
	var thead=$('#result thead');
	var $th = $('<th>');
	thead.append($th);
	for(var j=0;j<W+1;j++){
		var $th = $('<th>',{'text':j});
		thead.append($th);
	}
	
	for(var i=1;i<trs.length+1;i++){
		var $tr = $('<tr>');
		var $v = $('<td>',{'text':'x'+i})
		$tr.append($v);
		for(var j=0;j<W+1;j++){
			var $aux = $('<td>',{'text':K.tb[i][j]});
			$tr.append($aux);
		}
		$('#result tbody').append($tr);
	}

	
	var j = W;
	var i = trs.length;
	var p=0;
	while(j){
		console.log(K.tb[i][j],K.tb[i-1][j],'i='+i,'j='+j);
		while(K.tb[i][j]==K.tb[i-1][j]){
			i--;
		}
		console.log(i,V[i-1]);
		
		var $tr = $('<tr>');
		$tr.append($('<td>',{'text':'x'+i}));
		$tr.append($('<td>',{'text':V[i-1].valor}));
		$tr.append($('<td>',{'text':V[i-1].peso}));
		$('#tb-result').prepend($tr);
		p+=V[i-1].peso;
		j = (j-V[i-1].peso);
		i--;
	}
	
	var $tr = $('<tr>');
	var $desc = $('<td>').append($('<b>',{'text':'Resultado'}));
	var $result = $('<td>').append($('<b>',{'text':K.r}));
	var $peso = $('<td>').append($('<b>',{'text':p}));
	$tr.append($desc,$result,$peso);
	$('#tb-result').append($tr);
	
	$('#div-res').show();
}
</script>

</body>