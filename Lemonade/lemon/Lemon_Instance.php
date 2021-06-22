<?
/*
* 싱글톤 클래스
*/

class Lemon_Instance {

	public static $object = array();
	public static $dbCnt = 0;

	public static function isObject($name)
	{
		if(is_object(self::$object[$name]))
			return true;
		else
			return false;
	}

	public static function getObject($name)
	{
		// 메소드를 실행할때 같이 넘어온 인자값들을 추려낸다
		$getArgs = func_get_args();  // MySQL 외에 넘어온 인자값..
		unset($getArgs[0]);	// $name 에 해당하는 첫번째 인자만 제거한다.

		if($name!='Lemon_Mysql' && is_object(self::$object[$name])){ // is_object: 오브젝트인지 객체인지  검사
			return self::$object[$name];
		}
		//else if($name=='Lemon_Mysql' && is_object(self::$object[$name])){
		else if($name=='Lemon_Mysql')
		{
			// 만들려는 객체가 DB 이면 DB 의 host, user, passwd, db 값이 서로 일치할때에만 객체를 리턴한다
			// 값이 서로 틀리면 새로 DB 생성
			$tmp = self::$object[$name];
			
			if(is_array($tmp)){
				if(!is_array($getArgs[1])){
					$conf = Lemon_Configure::readConfig('database');
					$getArgs[1] = $conf['default'];
				}

				for($i=0;$i<count((array)$tmp);$i++){
					$getArgs2 = $tmp[$i]->getDBInfo();
					//echo "same, already DB object exists <br>";
					$arr = array_diff($getArgs[1],$getArgs2);
					if(count((array)$arr)==0)
						return $tmp[$i];
				}
			}
		}

		$name = ucfirst($name);

		if($name == 'Lemon_Mysql')
		{
			// new DB Object Create
			self::$object[$name][self::$dbCnt] = new $name($getArgs[1]);
			self::$dbCnt++;
			return self::$object[$name][self::$dbCnt-1];
		}
		else if(substr($name,-5)=='Model')
		{
			if($getArgs[1]===true){
				if($getArgs[2]=='rand')
				{
					$path = Lemon_Configure::readconfig('database');
					$rPathKey = array_keys($path);
					for($i=0,$j=0;$i<count((array)$rPathKey);$i++)
					{
						if(substr($rPathKey[$i],0,3)=='rand')
							$rDb[$j++] = $rPathKey[$i];
					}

					$rRandKey = array_rand($rDb);
					$db = Lemon_Connection::getConnection($rDb[$rRandKey]);
				}
				else if($getArgs[2]==''){
					$db = Lemon_Connection::getConnection('default');
				} else { 
					$db = Lemon_Connection::getConnection($getArgs[2]);
				}
				
				self::$object[$name] = new $name();
				$ref = new ReflectionClass(self::$object[$name]);
				$method = $ref->getMethod('setDB');
				$method->invoke(self::$object[$name],$db);
			}
			else
				self::$object[$name] = new $name();

			return self::$object[$name];
		}
		else {
			self::$object[$name] = new $name();

			return self::$object[$name];
		}
	}

}
?>
