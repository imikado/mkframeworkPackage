<?php
class model_#maTable# extends abstract_model implements interface_model{

	protected $sClassRow='row_#maTable#';

	protected $sTable='#maTable#';
	protected $sConfig='#maConfig#';

	protected $tId=array('#maTable_id#');

	public static function getInstance(){
		return self::_getInstance(__CLASS__);
	}

	public function findById($uId){
		return $this->findOne('SELECT * FROM '.$this->sTable.' WHERE #maTable_id#=?',$uId );
	}
	public function findAll(){
		return $this->findMany('SELECT * FROM '.$this->sTable);
	}

	#modelMethods#
	#modelSaveDuplicateKey#

}

class row_#maTable# extends abstract_row{

	protected $sClassModel='model_#maTable#';

	/*exemple jointure
	public function findAuteur(){
		return model_auteur::getInstance()->findById($this->auteur_id);
	}
	*/
	
	public function save(){
		throw new Exception ('disabled for pro template, please use model_#maTable#::getInstance()->update($object) or model_#maTable#::getInstance()->insert($object) instead');
	}

}
