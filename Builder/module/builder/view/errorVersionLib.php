<p class="error">Erreur dependences</p>

<?php $tReplace=array(
  'FMKVERSIONMIN'=>$this->sMinLibVersion,
  'FMKVERSIONCURR'=>$this->oLibJson->version,
  'PATHFMK'=>_root::getConfigVar('path.lib'),
);?>
<p><?php echo trR('builder::texteErreurVersion',$tReplace)?></p>
