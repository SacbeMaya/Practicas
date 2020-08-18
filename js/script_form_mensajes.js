//Obtener las referencias de los elementos del formulario
const enviar=document.getElementById("btnEnviar");
const nombre=document.getElementById("txtNombre");
const mensaje=document.getElementById("txtComentario");

enviar.addEventListener('click',function(){
	//Utilizando el API Fetch
	fetch("../php/script_form_mensajes.php",{
		method:"POST",
		headers:{
			"Content-type":"application/json; charset=utf-8"
		},
		body: JSON.stringify({
			_nombre:nombre.value,
			_comentario:mensaje.value,
		})
	})
	.then(function(respuesta){
		return respuesta.json();
	})
	.then(function(json){
		console.log(json);
		document.getElementById ('respuesta').innerHTMl="";
		
		let respuesta=`<tr>
						<th>Nombre</th>
						<th>Comentario</th>
					   </tr>`;
					 
		//Procesar el objeto JSON
		json.forEach(function(info){
			respuesta+= `<tr>
						   <td>${info.c_nombre}</td>
						   <td>${info.c_comentario}</td>
						</tr>`;
		});
		
		document.getElementById('respuesta').innerHTML=respuesta;
	})
	.catch(function(error){
		console.error("Error: ",error);
	});
});