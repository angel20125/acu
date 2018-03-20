function numeros(e) { 
tecla = (document.all) ? e.keyCode : e.which; 
if (tecla==8) return true; 
patron = /\d/; 
te = String.fromCharCode(tecla); 
return patron.test(te); 
}

function validar(e) { 
tecla = (document.all) ? e.keyCode : e.which; 
if (tecla==8 || tecla==16) return true;// 
patron =/[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+/;
te = String.fromCharCode(tecla);
return patron.test(te); 
}

