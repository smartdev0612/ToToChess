<?
class Lemon_Connection {

	public static function getConnection($kind='default') {
		$cf = Lemon_Configure::readConfig('database');
		return Lemon_Instance::getObject('Lemon_Mysql',$cf[$kind]);
	}
}
?>