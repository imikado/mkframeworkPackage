<?php 
/*

 /css/jquery-ui.css
 /css/trirand/ui.jqgrid.css
 /css/ui.multiselect.css
 
 /js/jquery.min.js" type="text/javascript
 /js/trirand/i18n/grid.locale-en.js
 
 /js/trirand/jquery.jqGrid.min.js
 /js/jquery-ui.min.js
 * 
 */

class module_guriddo extends abstract_moduleembedded{
	
	
	private $iLimit=0;
	private $sJsonLink=null;
	private $tHeader;
	private $tGroupHeader;
	
	private $iHeight=100;
	private $iWidth=600;
	private $tRowList;
	
	private $defaultSortField;
	
	private $idTable='grid';
	
	private $bEnableLoading=1;
    
	private $sDefaultSide='asc';
	
	private $bAltRows=false;
	private $bSortable=false;
	
	private $tFormatter;
	
	private $sUrlEdit=null;
	private $bEditEnable=0;
	private $bAddEnable=0;
	private $bDeleteEnable=0;
	private $bShowEnable=0;
	
	public function setPaginationLimit($iLimit){
		$this->iLimit=$iLimit;
	}
	public function setJsonLink($sJsonLink){
		$this->sJsonLink=$sJsonLink;
	}
	
	public function setListLimit($tList){
		$this->tRowList=$tList;
	}
        
	public function enableAltRows(){
		$this->bAltRows=true;
	}
	public function enableSortable(){
		$this->bSortable=true;
	}
	public function setDefaultSort($sSide){
		$this->sDefaultSide=$sSide;
	}
	
	public function addGroupColumn($sLabel,$iColspan,$sStartColumn,$tOption=null){
		if($tOption==null){
			$tOption=array();
		}
		$tOption['titleText']=$sLabel;
		$tOption['numberOfColumns']=$iColspan;
		$tOption['startColumnName']=$sStartColumn;
		
		$this->tGroupHeader[]=$tOption;
	}
	
	public function addColumn($sLabel,$sIndex,$tOption=null){
		if($tOption==null){
			$tOption=array();
		}
		$tOption['label']=$sLabel;
		$tOption['name']=$sIndex;
		
		$this->tHeader[]=$tOption;
	}
	
	public function enableEdit($sUrlEdit){
		$this->sUrlEdit=$sUrlEdit;
		$this->bEditEnable=1;
	}
	public function enableAdd($sUrlEdit){
		$this->sUrlEdit=$sUrlEdit;
		$this->bAddEnable=1;
	}
	public function enableDelete(){
		$this->bDeleteEnable=1;
	}
	public function enableShow(){
		$this->bShowEnable=1;
	}
	
	
	public function addHeaderWithOrder($sLabel,$sOrder){
		$this->tHeader[]=array('label'=>$sLabel,'order'=>$sOrder);
	}
	
	public function setWidth($iWidth){
		$this->iWidth=$iWidth;
	}
	public function setHeight($iHeight){
		$this->iHeight=$iHeight;
	}
	
	public function setId($idTable){
		$this->idTable=$idTable;

		$tOption['label']=$idTable;
		$tOption['name']=$idTable;
		$tOption['key']=true;
		$tOption['editable']=false;
		$tOption['hidden']=true;
		
		
		
		$this->tHeader[]=$tOption;
	}
	
	public function disableLoading(){
		$this->bEnableLoading=0;
	}
	
	public function _index(){
		$sAction='_'.self::getParam('Action','list');
		return $this->$sAction();
	}
	
	public function setDefaultSortField($sField){
		$this->defaultSortField=$sField;
	}
	
	public function build(){
	
		$oView=new _view('guriddo::build');
		$oView->iLimit=$this->iLimit;
		$oView->sJsonLink=$this->sJsonLink;
		$oView->tHeader=$this->tHeader;
		$oView->tGroupHeader=$this->tGroupHeader;
		$oView->tRowList=$this->tRowList;
		$oView->bAltRows=$this->bAltRows;	
		$oView->bSortable=$this->bSortable;
		
		$oView->sDefaultSide=$this->sDefaultSide;
		
		$oView->iHeight=$this->iHeight;
		$oView->iWidth=$this->iWidth;
		
		$oView->bEnableLoading=$this->bEnableLoading;
        
		$oView->tFormatter=$this->tFormatter;
		
		$oView->idTable=$this->idTable;
		
		$oView->sUrlEdit=$this->sUrlEdit;
		$oView->bShowEnable=$this->bShowEnable;
		$oView->bEditEnable=$this->bEditEnable;
		$oView->bAddEnable=$this->bAddEnable;
		$oView->bDeleteEnable=$this->bDeleteEnable;
		
		if($this->defaultSortField){
			$oView->defaultSortField=$this->defaultSortField;
		}else{
			$oView->defaultSortField=$this->tHeader[0]['order'];
		}
		
		return $oView;
	}
	
	public static function getJson(){
		return new module_jqGridJson();
	}

	
	
	
	
	
	
}
class module_jqGridJson{
	
	private $iTotal;
	private $tData;
	private $id;
	private $tColumn;
	
	private $iPaginationStart;
	private $iPaginationLimit;
	private $sPaginationSortField;
	private $sPaginationSortSide;
	
	private $sParamPage;
	private $sParamRows;
	private $sParamSidx;
	private $sParamSord;
	
	private $iTotalPage;
	
	private $tFilter=null;
	
	private $tSortAllowed=array('asc','desc');
	private $tSortFieldAllowed=array();
	
	public function __construct(){
		$this->tColumn=array();

		if(_root::getParam('filters')){
			$tFilter=json_decode(html_entity_decode(_root::getParam('filters')));
			foreach($tFilter->rules as $oFilter){
				$this->tFilter[$oFilter->field]=$oFilter->data;
			}
		} 
	}
	
	public function setSortAllowed($tSortAllowed){
		$this->tSortAllowed=$tSortAllowed;
	}
	public function setSortFieldAllowed($tSortFieldAllowed){
		$this->tSortFieldAllowed=$tSortFieldAllowed;
	}
	
	
	public function setTotal($iTotal){
		$this->iTotal=$iTotal;
		
		$this->sParamPage = _root::getParam('page'); 
		$this->sParamRows = _root::getParam('rows'); 
		$this->sParamSidx = _root::getParam('sidx',1); 
		$this->sParamSord = _root::getParam('sord'); 
		
		$this->sPaginationSortField=$this->sParamSidx;
		$this->sPaginationSortSide=$this->sParamSord;
		
		if( $this->iTotal > 0 && $this->sParamRows  > 0) { 
			$this->iTotalPage = ceil($this->iTotal/$this->sParamRows ); 
		} else { 
			$this->iTotalPage = 0; 
		} 
		if ($this->sParamPage > $this->iTotalPage){ 
			$this->sParamPage=$this->iTotalPage;
		}
		$this->iPaginationStart = $this->sParamRows *$this->sParamPage - $this->sParamRows ;
		if($this->iPaginationStart <0){ 
			$this->iPaginationStart = 0; 
		}
		
		$this->iPaginationLimit=$this->sParamRows;
	}
	public function setData($tData){
		$this->tData=$tData;
	}
	public function addData($oRow){
		$this->tData[]=$oRow;
	}
	
	public function setId($id){
		$this->id=$id;
	}
	public function addColumn($sColumn){
		$this->tColumn[]=$sColumn;
	}
	
	public function getStart(){
		return (int)$this->iPaginationStart;
	}
	public function getLimit(){
		return (int)$this->iPaginationLimit;
	}
	public function getSortField(){
		if(!in_array($this->sPaginationSortField,$this->tSortFieldAllowed)){
			throw new Exception('Field sort not Allowed: "'.$this->sPaginationSortField.'" not in '.implode(',',$this->tSortFieldAllowed));
		}
		return $this->sPaginationSortField;
	}
	public function getSortSide(){
		if(!in_array($this->sPaginationSortSide,$this->tSortAllowed)){
			throw new Exception('Side not Allowed: not in '.implode(',',$this->tSortAllowed));
		}
		return $this->sPaginationSortSide;
	}
	public function hasFilter(){
		
		if($this->tFilter){
			return true;
		}else{
			return false;
		}
	}
	public function getListFilter(){
		return $this->tFilter;
	}
	
	public function show(){
		
		$tData=$this->tData;
		
		$responce = new stdClass();
		$responce->page = $this->sParamPage;
		$responce->total = $this->iTotalPage;
		$responce->records = $this->iTotal;
		
		$sFieldId=$this->id;
		
		
		$i=0;
		foreach($tData as $oRow){
			//$responce->rows[$i]['id']=$oRow->$sFieldId;
			foreach($this->tColumn as $sColumn){
				$responce->rows[$i][$sColumn]=$oRow->$sColumn;
			}
			$i++;
		}
		
		
		echo json_encode($responce);exit;
	}
	
}
