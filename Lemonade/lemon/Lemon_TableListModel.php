<?
/*
* 한 테이블에 대해서 모델클래스를 별도로 만들지 않고 손쉽게 조회하고자 할때 사용
*
* @author 강민식
* @date 2007-12-15
*/
class Lemon_TableListModel extends Ez_Model {

	private $table = null;
	private $field = "*";
	private $where = null;
	private $order = null;

	public function setTable($table){
		$this->table = $table;
	}

	public function setField($field){
		$this->field = $field;
	}

	public function setWhere($where){
		$this->where = $where;
	}

	public function setOrder($order){
		$this->order = $order;
	}

	public function getList($first='',$amount=''){
		if(empty($first)){
			if(is_numeric($first))
				$first = 0;
			else
				$first = 'nodata';
		}

		$sql = "select ".$this->field."
				from ".$this->table.
				($this->where==null?'':" where ".$this->where).
				($this->order==''?'':" order by ".$this->order).
				(($first=='nodata' && $amount=='')?'':" limit ".$first.",".$amount);

		if(($rs = $this->db->exeSql($sql))===false){
			//throw new Lemon_ScriptException("에러 발생 : ",$this->db->errorMsg);
			throw new Lemon_ScriptException("에러 발생 : ","잘못된 접근 또는 오류가 발생했습니다");
			exit;
		}

		$this->table = '';
		$this->field = '';
		$this->where = '';
		$this->order = '';

		return $rs;
	}
}

?>