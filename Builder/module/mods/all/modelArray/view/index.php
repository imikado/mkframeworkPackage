<style>
#divFrom{
display:none;
}
.bloc{
border:1px solid #444;
margin:8px;
}
.bloc h2{
background:#444;
margin-top:0px;
color:white;
padding:2px 4px;
}
</style>
<script>
function addLine(){
  var a=getById('divList');
  var b=getById('divFrom');
  if(a && b){
		var node = document.createElement("p");
		node.innerHTML=b.innerHTML+' <a href="#" onclick="removeLine(this.parentNode);return false;"><?php echo tr('supprimer')?></a>';

		a.appendChild(node);
	}
}
function removeLine(nodeToDelete){
	var a=getById('divList');
	a.removeChild(nodeToDelete);
}
function resetValue(input){
	input.value='';
}
</script>
<form action="" method="POST">

    <p><?php echo tr('Classe')?> model_<input type="text" name="maTable" value="maTable"/></p>

    <div class="bloc">
    <h2><?php echo tr('Liste')?></h2>
    <div id="divList">

    </div>
    <p><input onclick="addLine()" type="button" value="<?php echo tr('Ajouter')?>"/></p>
    </div>


    <p><input type="submit" value="<?php echo tr('generer')?>" /></p>
</form>

<div id="divFrom"><input type="text" name="cle[]" value="cle" onclick="resetValue(this)"/> = <input type="text" name="val[]" value="Valeur" onclick="resetValue(this)" /></div>

<p class="msg"><?php echo $this->msg?></p>
<p class="detail"><?php echo $this->detail?></p>

<script>
addLine();
</script>
