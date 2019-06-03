<head>
<!--<meta http-equiv="Content-Language" content="pt-br">-->
<meta charset='UTF-8'>
<title>
	Pesquisa Operacional JS - Simplex
</title>
</head>
<body>
<link rel='stylesheet' type='text/css' href='../bootstrap-4.3.1-dist/css/bootstrap.css'></link>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<div id='main' class='content container'>
	<button class='btn btn-primary' onclick='location.href="../"' style='margin:10px 0px 20px 0px'>Voltar para a Página Inicial</button>
	
	<div>
		<div class='row'><h3>Função Objetiva</h3></div>
		<button class='btn btn-primary' onclick='addVariavel()'>Adicionar Variável</button>
		<button class='btn btn-primary' onclick='removeVariavel()'>Remover Variável</button>
		<div class='row' style='padding:10px'>
			<div id='funcao' class='fo row'>
				<div class="input input-group mb-1 col">
					<input type="number" class="var form-control" id='x1' value='0'>
					<div class="input-group-append">
						<span class="input-group-text">x1</span>
					</div>
				</div>
				<!--<div class='input'><input id='x1' class='var' type='number' value='0'><label for='x1'>x1</label></div> --><span class='symbol plus '><b> + </b></span>
				<!-- <div class='input'><input id='x2' class='var' type='number' value='0'><label for='x2'>x2</label></div> -->
				<div class="input input-group mb-1 col">
					<input type="number" class="var form-control" id='x2' value='0'>
					<div class="input-group-append">
						<span class="input-group-text">x2</span>
					</div>
				</div>

			</div>
		</div>
	</div>
	<hr>
	<div>
		<div class='row'><h3>Restrições</h3></div>

		<button class='btn btn-primary' onclick='addRestricao()'>Adicionar Restricão</button>
		<button class='btn btn-primary'onclick='removeRestricao()'>Remover Restricão</button>

		<div id='restricoes' class='res row' style='padding:10px'>
			<div class='restricao row'>
				<div class="input input-group mb-1 col">
					<input type="number" class="var form-control" id='x1' value='0'>
					<div class="input-group-append">
						<span class="input-group-text">x1</span>
					</div>
				</div>
				<span class='symbol plus '><b> + </b></span>
				<div class="input input-group mb-1 col">
					<input type="number" class="var form-control" id='x2' value='0'>
					<div class="input-group-append">
						<span class="input-group-text">x2</span>
					</div>
				</div>
				<span class='symbol equal'><b> <= </b></span>
				<div class="result input-group mb-1 col">
					<input type="number" class="res form-control" id='' value='0'>
				</div>
				
			</div>
		</div>
	</div>
	<hr>
	<div class="custom-control custom-switch">
		<input type="checkbox" class="custom-control-input" id="min">
		<label class="custom-control-label" for="min">Minimizar</label>
	</div>

	<div class='row'>
	<div class="input-group mb-1 col-3">
		<div class="input-group-prepend">
			<span class="input-group-text">Máximo de Iterações</span>
		</div>
		<input type="number" class="var form-control" id='it' value='100'>
	</div>
	<div class='col-3'><button class='btn btn-primary' onclick='execute()'>Executar</button></div>
	</div>

	
	

	<div id='card-result' class="card" style='display:none'>
		<div class="card-header">
		Resultado
		</div>
		<div id='divResolucao' class="card-body">
			<div id='inicio'></div>
			<table class='table' id='tbResolucao'>
			</table>
			<div id='final'></div>
		</div>
		<div id='divAnalise' class="card-body" style='display:none'>
			<table class='table' id='tbAnalise'>
			</table>
		</div>
	</div>
</div>
	
	
	
	
	<script src="simplex.js"></script>
	<script src="../bootstrap-4.3.1-dist/js/bootstrap.js"></script>
	<script src="../jquery-3.4.1.min.js"></script>
	<script>
	const ADD = 'add';
	const REM = 'rem';
	var result = undefined;
	function updateRestricoes(type){
		if(type==ADD){
			$('#restricoes').children().each(function(idx,obj){
				index = idx+1;
				var last = $('#restricoes input.var').last();
				var id = 'x'+(Number(last.attr('id').substr(1))+1);
				var $div = $('<div>',{'class':'input input-group mb-1 col'});
				var $input = $('<input>',{'id':id,'class':'var form-control','type':'number'});
				var $divappend = $('<div>',{'class':'input-group-append'});
				var $spanappend = $('<span>',{'class':'input-group-text'}).text(id);
				<!-- var $label = $('<label>',{'for':id}).text(id); -->
				var symbol = $('.symbol.plus').first().clone();
				$div.append($input);
				$div.append($divappend);
				$div.append($spanappend);
				symbol.insertBefore($('#restricoes .restricao:nth-child('+index+') .symbol.equal'));
				$div.insertBefore($('#restricoes .restricao:nth-child('+index+') .symbol.equal'));
			});
			return true;
		}else if(type==REM){
			$('#restricoes .restricao').each(function(idx,obj){
				var index = Number(idx)+1
				$('#restricoes .restricao:nth-child('+index+') .input').last().remove();
				$('#restricoes .restricao:nth-child('+index+') .symbol.plus').last().remove();
			});
			
			return true;
		}
		return false;
	}
	function addVariavel(){
		var last = $('#funcao input.var').last();
		var id = 'x'+(Number(last.attr('id').substr(1))+1);
		var $div = $('<div>',{'class':'input input-group mb-1 col'});
		var $input = $('<input>',{'id':id,'class':'var form-control','type':'number'});
		var $divappend = $('<div>',{'class':'input-group-append'});
		var $spanappend = $('<span>',{'class':'input-group-text'}).text(id);
		<!-- var $label = $('<label>',{'for':id}).text(id); -->
		var symbol = $('.symbol.plus').first().clone();
		$div.append($input);
		$div.append($divappend);
		$div.append($spanappend);
		<!-- $div.append($label); -->
		$('#funcao').append(symbol);
		$('#funcao').append($div);
		
		updateRestricoes(ADD);
	}
  
	function removeVariavel(){
		var inputs = $('#funcao .input').length;
		var last = $('#funcao .input:last-child');
		if(inputs>2){
			last.remove();
			$('#funcao .symbol.plus').last().remove();
			updateRestricoes(REM);
		}
		
	}
	
	function addRestricao(){
		var clone = $('#restricoes .restricao').first().clone();
		clone.find('input').each(function(idx,obj){
			obj.value = 0;
		});
		$('#restricoes').append(clone);
	}
	
	function removeRestricao(){
		if($('#restricoes .restricao').length>1)
			$('#restricoes .restricao').last().remove();
	}
	
	function execute(){
		var s = new Simplex();

		
		$('#funcao input').each(function(idx,obj){
			s.addVariavel(obj.id,Number(obj.value));
		});
		$('#restricoes .restricao').each(function(idx,obj){
			s.addRestricao();
			var index = idx+1;
			$('#restricoes .restricao:nth-child('+index+') input.var').each(function(idx,obj){
				s.setValorVariavelRestricao(Number(obj.value),obj.id,index-1);
			});
			s.setResultRestricao($('#restricoes .restricao:nth-child('+index+') input.res').val(),index-1);
		});
		var it = Number($('#it').val());
		if($('#min:checked').val()=='on')
			result = s.execute(it,true);
		else
			result = s.execute(it,false);
		$('#btnProx').remove();
		$('#btnAnte').remove();
		$('#btnAnalise').remove();
		var check = resultado(0,s);
		$('#card-result').show();
		$('#divAnalise').hide();
		$('html, body').animate({
			scrollTop: ($('#final').offset().top)
		},1000);
		$('#btnSolu').remove();
		if(result.iteracao.length>1 && check){
			var bt = $('<button>',{'text':'Solução Direta','id':'btnSolu','class':'btn btn-primary float-right'}).bind('click',function(){
				$('#btnAnte').remove();
				$('#btnProx').remove();
				$('#btnAnalise').remove();			
				resultado(result.iteracao.length-1,s);
			});
			$('.card-header').append(bt);
		}
	}
	function resultado(i,s){
		var check = false;
		$('#inicio').children().remove();
		$('#final').empty();
		$('table#tbResolucao').text('');
		var test = result.iteracao[result.iteracao.length-1].tabela[result.iteracao[0].tabela.length-1];
		for(aux in result.iteracao[result.iteracao.length-1].tabela[result.iteracao[0].tabela.length-1]){
			if(aux!='b' && aux!='base'){
				if(test[aux]<0) check = true;
			}
		}
		if(check){
			var ilimitada = $('<p>').append($('<b>').text('Sem Solução'));
			$('#inicio').append(ilimitada);
			var head = $('<thead>',{'id':'thResolucao'});
			for(k in result.iteracao[0].tabela[0]){
				head.append($('<th>').text(k));
			}
			$('table#tbResolucao').append(head);
			var body = $('<tbody>');
			result.iteracao[0].tabela.forEach(function(obj,idx){
				var row = $('<tr>');
				<!-- console.log(idx,obj); -->
				body.append(row);
				for(k in obj){
					row.append($('<td>').text(obj[k]));
				}
				
			});
			$('table#tbResolucao').append(body);
			return false;
		}
		else {
		if(i==0){
			var funcao = $('<p>').append($('<b>').text('Z = '+result.inicio.z));
			$('#inicio').append(funcao);
			for(j in result.inicio.restricoes){
				var text = '';
				var line = $('<p>');
				for(k in result.inicio.restricoes[j].antes){
					if(k=='result'){
						text += ' = ';
						text += result.inicio.restricoes[j].antes[k];
						break;
					}
					else{
						text += result.inicio.restricoes[j].antes[k] + k;
						text += ' + ';
					}
				}
				line.append($('<b>').append(document.createTextNode(text)));
				line.append($('<i>',{'class':'fas fa-long-arrow-alt-right','style':'padding:0px 4px 0px 4px'}));
				text = '';
				for(k in result.inicio.restricoes[j].depois){
					if(k=='result'){
						text += ' = ';
						text += result.inicio.restricoes[j].depois[k]
						break;
					}
					else{
						text += result.inicio.restricoes[j].depois[k] + k;
						text += ' + ';
					}
				}
				line.append($('<b>').append(document.createTextNode(text)));
				$('#inicio').append(line);
			}
			if(i<result.iteracao.length-1){
				var bt = $('<button>',{'text':'Proximo','id':'btnProx','class':'btn btn-primary float-right'}).bind('click',function(){
					resultado(1,s);
					$(this).remove();
				});
				$('#divResolucao').append(bt);
				
			}
		}
		else{
			var sai = result.iteracao[i-1].pivo.linha;
			var entra = result.iteracao[i-1].pivo.coluna;
			var passo = $('<p>').text('Sai:');
			passo.append($('<b>').text(sai));
			passo.append('   ');
			passo.append('Entra:');
			passo.append($('<b>').text(entra));
			$('#inicio').children().remove();
			$('#inicio').append(passo);
			var btnAnte = $('<button>',{'text':'Anterior','id':'btnAnte','class':'btn btn-primary float-left'}).bind('click',function(){
				$('#btnProx').remove();
				$('#btnAnalise').remove();
				$('#divAnalise').hide();
				$('#final').empty();
				resultado(i-1,s);
				$(this).remove();
			});
			$('#divResolucao').append(btnAnte);
			if(i<result.iteracao.length-1){
				var btnProx = $('<button>',{'text':'Proximo','id':'btnProx','class':'btn btn-primary float-right'}).bind('click',function(){
					$('#btnAnte').remove();
					resultado(i+1,s);
					$(this).remove();
				});
				$('#divResolucao').append(btnProx);
				
			}
			else{
				var center = $('<center>');
				var btnAnalise = $('<button>',{'text':'Analise','id':'btnAnalise','class':'btn btn-primary'}).bind('click',function(){
					if(!$('#divAnalise').is(':visible')){
						$('#divAnalise').show();
						analise(i);
					}
				});
				$('#divResolucao').append(center.append(btnAnalise));
				
				if(result.minmax)
					$('#final').append($('<p>').append(document.createTextNode('Solucao ótima e Z = '+(s.funcao.result))));
				else
					$('#final').append($('<p>').append(document.createTextNode('Solucao ótima e Z = '+(-s.funcao.result))));
				result.variaveis_basicas.forEach(function(obj,idx){
					var b = 0;
					result.iteracao[i].tabela.forEach(function(item,idx){
						if(item.base==obj) b = item.b;
					});
					$('#final').append($('<p>').append(document.createTextNode(obj+' = '+b)));
				});
			}
		}
		var head = $('<thead>',{'id':'thResolucao'});
		for(k in result.iteracao[0].tabela[0]){
			head.append($('<th>').text(k));
		}
		$('table#tbResolucao').append(head);
		var body = $('<tbody>');
		result.iteracao[i].tabela.forEach(function(obj,idx){
			var row = $('<tr>');
			<!-- console.log(idx,obj); -->
			body.append(row);
			for(k in obj){
				row.append($('<td>').text(obj[k]));
			}
			
		});
		$('table#tbResolucao').append(body);
		$('html, body').animate({
			scrollTop: ($('#final').offset().top)
		},1000);
		<!-- console.log(1); -->
		return true;
		}
	}
	
	function analise(i){
		$('table#tbAnalise').empty();
		var head = $('<thead>',{'id':'thAnalise'});
		head.append($('<th>',{'text':'Variável'}));
		head.append($('<th>',{'text':'Valor Inicial'}));
		head.append($('<th>',{'text':'Valor Final'}));
		head.append($('<th>',{'text':'Preco Sombra'}));
		head.append($('<th>',{'text':'Maximo'}));
		head.append($('<th>',{'text':'Minimo'}));
		$('table#tbAnalise').append(head);
		var body = $('<tbody>');
		result.variaveis_basicas.forEach(function(obj){
			var b = 0;
			var row = $('<tr>',{'id':obj+'_'});
			row.append($('<td>',{'text':obj}));
			row.append($('<td>',{'text':0}));
			result.iteracao[i].tabela.forEach(function(item,idx){
				if(obj==item.base) b = item.b;
			});
			row.append($('<td>',{'text':b}));
			row.append($('<td>'));
			row.append($('<td>'));
			row.append($('<td>'));
			body.append(row);
		});
		result.variaveis_folga.forEach(function(obj){
			var b = 0;
			var row = $('<tr>',{'id':obj+'_'});
			row.append($('<td>',{'text':obj}));
			row.append($('<td>',{'text':result.iteracao[0].tabela[Number(obj.substr(1))-1].b}));
			result.iteracao[i].tabela.forEach(function(item,idx){
				if(obj==item.base){
					b = item.b;
				}
			});
			row.append($('<td>',{'text':b}));
			//if(b==0){
				var val = result.iteracao[i].tabela[result.iteracao[i].tabela.length-1][obj];
				<!-- console.log(result.iteracao[i].tabela[result.iteracao[i].tabela.length]); -->
				row.append($('<td>',{'text':val}));
				var max = 0;
				var min = 0;
				result.iteracao[i].tabela.forEach(function(item,idx){
					if(item.base!='Z' && item[obj]!=0){
						if(-(item.b/item[obj])>0 && -(item.b/item[obj])>max) max = -item.b/item[obj];
						if(-(item.b/item[obj])<0 && -(item.b/item[obj])<min) min = item.b/item[obj];
					}
				});
				if(max!=0)
					row.append($('<td>',{'text':max}));
				else
					row.append($('<td>',{'text':Infinity}));
				if(min!=0)
					row.append($('<td>',{'text':min}));
				else
					row.append($('<td>',{'text':Infinity}));
			body.append(row);
		});
		var row = $('<tr>',{'id':'Z_'});
		row.append($('<td>',{'text':'Z'}));
		row.append($('<td>',{'text':result.iteracao[0].tabela[result.iteracao[0].tabela.length-1].b}));
		row.append($('<td>',{'text':result.iteracao[i].tabela[result.iteracao[0].tabela.length-1].b}));
		row.append($('<td>'));
		row.append($('<td>'));
		row.append($('<td>'));
		body.append(row);
		$('table#tbAnalise').append(body);
		$('html, body').animate({
			scrollTop: ($('#tbAnalise').offset().top)
		},1000);
	}
	</script>
	
</body>