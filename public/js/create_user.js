function numeros(e) { 
tecla = (document.all) ? e.keyCode : e.which; 
if (tecla==8) return true; 
patron = /\d/; 
te = String.fromCharCode(tecla); 
return patron.test(te); 
}

function validar(e) { 
tecla = (document.all) ? e.keyCode : e.which; 
if (tecla==8) return true;// 3
patron =/[A-Za-z\s]/; 
te = String.fromCharCode(tecla);
return patron.test(te); 
}
