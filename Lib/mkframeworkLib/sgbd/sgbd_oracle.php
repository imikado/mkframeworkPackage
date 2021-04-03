<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
class sgbd_oracle extends abstract_sgbd{

	public static function getInstance($sConfig){
		return self::_getInstance(__CLASS__,$sConfig);
	}

	public function findMany($tSql,$sClassRow){
		$pRs=$this->query($this->bind($tSql));

		if(empty($pRs)){
			return null;
		}

		$tObj=array();
		while($tRow=oci_fetch_assoc($pRs)){
			$oRow=new $sClassRow($tRow);
			if( (int)_root::getConfigVar('security.xss.model.enabled',0)==1 ){
				$oRow->enableCleaning();
			}
			$tObj[]=$oRow;
		}
		return $tObj;
	}
	public function findManySimple($tSql,$sClassRow){
		$pRs=$this->query($this->bind($tSql));

		if(empty($pRs)){
			return null;
		}

		$tObj=array();
		while($oRow=oci_fetch_object($pRs)){
			$tObj[]=$oRow;
		}
		return $tObj;
	}
	public function findOne($tSql,$sClassRow){
		$pRs=$this->query($this->bind($tSql));

		if(empty($pRs)){
			return null;
		}

		$tRow=oci_fetch_assoc($pRs);
		$oRow=new $sClassRow($tRow);
		if( (int)_root::getConfigVar('security.xss.model.enabled',0)==1 ){
			$oRow->enableCleaning();
		}

		return $oRow;
	}
	public function findOneSimple($tSql,$sClassRow){
		$pRs=$this->query($this->bind($tSql));

		if(empty($pRs)){
			return null;
		}

		$oRow=oci_fetch_object($pRs);

		return $oRow;
	}
	public function execute($tSql){
		return $this->query($this->bind($tSql));
	}

	public function update($sTable,$tProperty,$twhere){
		$this->query('UPDATE '.$sTable.' SET '.$this->getUpdateFromTab($tProperty).' WHERE '.$this->getWhereFromTab($twhere));
	}
	public function insert($sTable,$tProperty){
		$this->query('INSERT INTO '.$sTable.' '.$this->getInsertFromTab($tProperty));
	}

	public function delete($sTable,$twhere){
		$this->query('DELETE FROM '.$sTable.' WHERE '.$this->getWhereFromTab($twhere));
	}

	public function getListColumn($sTable){
		$pRs=$this->query(sgbd_syntax_oracle::getListColumn($sTable));
		$tCol=array();

		if(empty($pRs)){
			return $tCol;
		}

		while($tRow=oci_fetch_row($pRs)){
			$tCol[]=$tRow[0];
		}

		return $tCol;
	}
	public function getListTable(){
		$pRs=$this->query(sgbd_syntax_oracle::getListTable());
		$tCol=array();

		if(empty($pRs)){
			return $tCol;
		}

		while($tRow=oci_fetch_row($pRs)){
			$tCol[]=$tRow[0];
		}
		return $tCol;
	}

	private function connect(){
		if(empty($this->_pDb)){

			if(isset($this->_tConfig[$this->_sConfig.'.character_set'])){
				if( ($this->_pDb=oci_connect(

						$this->_tConfig[$this->_sConfig.'.username'],
						$this->_tConfig[$this->_sConfig.'.password'],
						$this->_tConfig[$this->_sConfig.'.hostname'].'/'.$this->_tConfig[$this->_sConfig.'.database'],
						$this->_tConfig[$this->_sConfig.'.character_set']

				))==false ){
					$e = oci_error();
					throw new Exception('Probleme connexion sql : '.$e['message']);
				}
			}else{
				if( ($this->_pDb=oci_connect(

						$this->_tConfig[$this->_sConfig.'.username'],
						$this->_tConfig[$this->_sConfig.'.password'],
						$this->_tConfig[$this->_sConfig.'.hostname'].'/'.$this->_tConfig[$this->_sConfig.'.database']

				))==false ){
					$e = oci_error();
					throw new Exception('Probleme connexion sql : '.$e['message']);
				}
			}




		}
	}
	public function getLastInsertId(){
		return null;
	}

    private function query($sReq)
    {
        $this->connect();
        $this->_sReq = $sReq;
        $query       = oci_parse($this->_pDb, $sReq);

        if (isset($this->_tConfig[$this->_sConfig . '.useTransaction']) && $this->_tConfig[$this->_sConfig . '.useTransaction'] == 1) {
            oci_execute($query, OCI_NO_AUTO_COMMIT);
        } else {
            oci_execute($query);
        }

        return $query;
    }

	public function quote($sVal){
		if ( isset($this->_tConfig[$this->_sConfig.'.escapeDateField']) && $this->_tConfig[$this->_sConfig.'.escapeDateField']==1 && (preg_match('!^TO_DATE\(.*\)!', $sVal) || preg_match('!^TO_TIMESTAMP\(.*\)!', $sVal))    ) {
			return $sVal;
		}
		return str_replace("\\",'', str_replace("'",'\'',"'".$sVal."'"));
	}
	public function getWhereAll(){
		return '1=1';
	}

    /**
     * @param $request
     * @return false|resource
     */
    public function ociBindByName($request)
    {
        return oci_parse($this->_pDb, $request);
    }

    /**
     * @return bool
     */
    public function commit()
    {
        return oci_commit($this->_pDb);
    }

    /**
     * @return bool
     */
    public function rollback()
    {
        return oci_rollback($this->_pDb);
    }

    /**
     * @return array|false
     */
    public function getError()
    {
        return oci_error($this->_pDb);
    }

}
