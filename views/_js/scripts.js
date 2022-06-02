
$(document).ready(function(){ 
    if ($("#main-content" ).hasClass("frente-de-caixa")) {
        $(document).on("keydown", keydown);
	}
	
	$(".cnpj").mask("99.999.999/9999-99");
	$('.money').mask("###0,00", {reverse: true});
	var SPMaskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
		onKeyPress: function(val, e, field, options) {
			field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};
	$('.phone').mask(SPMaskBehavior, spOptions);

	if (document.getElementById('fechar-cupom') != null) {
        $(document).on("keydown", fecharCaixa);
	}

	// Função responsável pela busca de produto por nome
	if (document.getElementById('input-entrada-caixa') != null) {
        $('#input-entrada-caixa').on("keyup", buscaProduto);
	}

	if (document.getElementById('recorrencia-select') != null) {
		$( "#recorrencia-select" ).change(function() {
			if (this.value == '1') {
				$(".form-group-dia-recorrencia").css('display', 'flex');
				$(".form-group-data-pagamento").hide();
				$(".form-group-repetir-cobranca").hide();
			} else {
				$(".form-group-dia-recorrencia").hide();
				$(".form-group-data-pagamento").css('display', 'flex');
				$(".form-group-repetir-cobranca").css('display', 'flex');
			}
		});
	}

    $("#select-parceiro").on('change', function() {
		if (this.value != 0) {
			$(".oculta-parceiro").hide();
		} else {
			$(".oculta-parceiro").show();
		}
	});
});

$('.selectMultiple').select2({ width: '100%' });

$('.selectMultiple').select2({
	width: 'element',
   minimumResultsForSearch: Infinity
 });

function keydown(e) { 
	if ((e.which || e.keyCode) == 116 ) {
		// Pressing F5 or Ctrl+R
		e.preventDefault();
		var id_pedido = $("#input-id-pedido-caixa").val();
		window.location.replace(HOME_URI+'/caixa/fechar-cupom/'+id_pedido);
	}
};

function fecharCaixa(e) {
	if ((e.which || e.keyCode) == 67 ) { // Cartão
		document.getElementById("metodo_pagamento").value = "2";
		document.getElementById("form-fechar-cupom").submit();
	} else if((e.which || e.keyCode) == 68) {
		document.getElementById("metodo_pagamento").value = "1";
		document.getElementById("form-fechar-cupom").submit();
	}
}

function buscaProduto(e) {
	if (e.target.value.length >= 3 && !($.isNumeric(e.target.value) || e.target.value.includes('*'))) {
		$.get( HOME_URI+"/caixa/busca_produto", {'busca': e.target.value}, function(retorno) {
			retorno = JSON.parse(retorno);
			if (retorno.length > 0) {
				$("#input-entrada-caixa").replaceWith('<select id="input-entrada-caixa" name="entrada-caixa" class="form-control" dir="rtl"></select>');
				retorno.forEach(element => {
					$("#input-entrada-caixa").append(
						'<option value="'+element.id+'">'+element.nome+'</option>'
					);
				});
				$("#input-entrada-caixa").show().focus().click();
				$(document).on("keydown", limpaSelect);
			}
		})
	}
}

function limpaSelect(e) {
	if ((e.which || e.keyCode) == 8 ) {
		window.location.replace(HOME_URI+'/caixa/frente-de-caixa/');
	} else if((e.which || e.keyCode) == 13) {
		$("#form-entrada-caixa").submit();
	}
}