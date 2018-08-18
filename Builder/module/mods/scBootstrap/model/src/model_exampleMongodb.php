<?php
class model_exampletb extends abstract_model implements interface_model
{
    protected $sClassRow='row_exampletb';

    protected $sTable='exampletb';
    protected $sConfig='exampleconfig';

    protected $tId=array('exampleid');

    public static function getInstance()
    {
        return self::_getInstance(__CLASS__);
    }

    public function findById($uId)
    {
        return $this->findOne($this->sTable, array('exampleid' => new MongoId($uId)));
    }
    public function findAll()
    {
        return $this->findMany($this->sTable);
    }

    //ICI
    //sSaveDuplicateKey
}

class row_exampletb extends abstract_rownosql
{
    protected $sClassModel='model_exampletb';

    /*exemple jointure
    public function findAuteur(){
        return model_auteur::getInstance()->findById($this->auteur_id);
    }
    */
    
    public function save()
    {
        throw new Exception('disabled for pro template, please use model_#maTable#::getInstance()->save($object) instead');
    }
}
