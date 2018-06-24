<?php
class module_mods_all_modelArray extends abstract_moduleBuilder{

	protected $sModule='mods_all_modelArray';
	protected $sModuleView='mods/all/modelArray';

	private $msg=null;
	private $detail=null;
	private $tError=null;

	public function _index(){
		$tMessage=$this->process();

		$oTpl= $this->getView('index');
		//$oTpl->var=$var;

		$oTpl->msg=$this->msg;
		$oTpl->detail=$this->detail;
		$oTpl->tError=$this->tError;

		return $oTpl;
	}
	private function process(){
		if(_root::getRequest()->isPost()==false){
			return null;
		}

		$sTable=_root::getParam('maTable');

		$this->msg=tr('coucheModeleGenereAvecSucces');
		$this->detail=trR('CreationDuFichierVAR',array('#FICHIER#'=>'model/model_'.$sTable.'.php'));

		/*SOURCE*/$oSourceModel=$this->getObjectSource('example.php');
		/*SOURCE*/$oSourceModel->setPattern('#maTable#',$sTable);

		$sData=null;

		$tKey=_root::getParam('cle');
		$tVal=_root::getParam('val');

		foreach($tKey as $i => $sKey){
			$sVal=$tVal[$i];

			$sData.=$oSourceModel->getSnippet(
								'dataRow',
								array(
									'#key#'=>$sKey,
									'#val#'=>$sVal
								)
			);
		}



		/*SOURCE*/$oSourceModel->setPattern('#data#',$sData);
		/*SOURCE*/$oSourceModel->save();

	}

}
