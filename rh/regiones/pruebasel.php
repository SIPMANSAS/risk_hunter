<div>
  <select name='id_categoria' id='id_categoria' onchange="carg(this);">
      <option value="0" selected>SELECCIONAR</option>
      <option value="1">FI</option>
      <option value="2">COMP</option>
  </select>
  <input id="input" type="text" placeholder="FIRMA">
  <input id="input2" type="text" placeholder="TELEFONO">
  
</div>

<script>
    var input = document.getElementById('input');
    var input = document.getElementById('input2');

function carg(elemento) {
  d = elemento.value;
  
  if(d == "2"){
    input.disabled = false;
    input2.disabled = false;
  }else{
    input.disabled = true;
    input2.disabled = true;
  }
}
</script>