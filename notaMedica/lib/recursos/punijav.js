function fe(cte){
 
    var form =document.getcatalogo;
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}
	else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("catalogo").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","list_factexp.php?cliente="+cte,true);
	xmlhttp.send();
}

function maximos(cte,filtro){
 
    var form =document.getcatalogo;
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}
	else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("catalogo").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","list_maximos.php?almacen="+cte+"&filtro="+filtro,true);
	xmlhttp.send();
}