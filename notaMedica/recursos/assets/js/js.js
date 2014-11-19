// JavaScript Document
var ordenar = '';
$(document).ready(function(){
	
	// Llamando a la funcion de busqueda al
	// cargar la pagina
	filtrar()
	
	var dates = $( "#del, #al" ).datepicker({
			yearRange: "-50",
			dateFormat: 'dd/mm/yy',
			defaultDate: "+1d",
			changeMonth: true,
			changeYear: true,
			onSelect: function( selectedDate ) {
				var option = this.id == "del" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
	});
	
	// filtrar al darle click al boton
	$("#btnfiltrar").click(function(){ filtrar() });
	
	// boton cancelar
	$("#btncancel").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		filtrar() 
	});
	
	// ordenar por
	$("#data th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar()
	});
});

function filtrar()
{	
	$.ajax({
		data: $("#frm_filtro").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "rxSolicitados.php?action=listar",
			success: function(data){
				var html = '';				
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							//html += '<td align="center"><a href="marco.php?op=881&docto='+item.documento+'&serie='+item.serie+'">'+item.documento+'</a></td>'
							//html += '<td align="center">'+item.folio+'</td>'
							html += '<td align="center">'+item.Clave+'</td>'
							html += '<td align="center">'+item.Folio+'</td>'
							html += '<td>'+item.Nombre+'</td>'
							html += '<td align="center">'+item.Fecha+'</td>'
							html += '<td align="center">'+item.Estatus+'</td>'
							html += '<td align="center"><a href="/Expedientes/'+item.Formato+'/'+item.Folio+'/SRx_'+item.Folio+'.pdf" target="_blank">Formato</a></td>'
							//html += '<td align="center"><a href="imagesRx.php?clave='+item.Clave+'">Subir Imagen</a></td>'
							if(item.Imagen==''){html += '<td align="center"><a href="subeimagesRx.php?clave='+item.Clave+'">Subir Imagen</a></td>'} else{html += '<td align="center">OK</td>'}
						html += '</tr>';
															
					});					
				}
				if(html == '') html = '<tr><td colspan="7" align="center">No se encontraron registros..</td></tr>'
				$("#data tbody").html(html);
			}
	  });
}