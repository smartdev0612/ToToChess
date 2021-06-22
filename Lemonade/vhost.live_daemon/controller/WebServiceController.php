<?
class WebServiceController extends Lemon_Controller 
{
	public function notfound()
	{
		echo "not found";
	}

	public function display() 
	{
		$this->view->print_('index');
	}
	
	public function commonDefine($type='')
	{	
		// 헤더/푸터
		$this->view->define("index","layout/layout.html");
		$this->view->define(array("header"=>"header/header.html", "top" => "header/top.html", "footer" => "footer/footer.html", "left" =>"left/left.html", "right" => "right/right.html", "right_normal" => "right/right_normal.html"));
	}
	
	/* model help function */
	function getModel($model)
	{
		return Lemon_Instance::getObject($model,true);
	}
}
?>