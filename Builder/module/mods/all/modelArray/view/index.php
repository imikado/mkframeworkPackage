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
    a.innerHTML+=b.innerHTML;
  }
}
</script>
<form action="" method="POST">
    
    <p><?php echo tr('Classe')?> <input type="text" name="filename" value="model_"/></p>
    
    <div class="bloc">
    <h2><?php echo tr('Liste')?></h2>
    <div id="divList">
        
    </div>
    <p><input onclick="addLine()" type="button" value="<?php echo tr('Ajouter')?>"/></p>
    </div>
    
    <div id="divFrom"><p><input type="text" name="cle[]" value="cle"/> <input type="text" name="val[]" value="Valeur" /><p></div>
     
    <p><input type="submit" value="<?php echo tr('generer')?>" /></p>
</form>
<script>
addLine();
</script>