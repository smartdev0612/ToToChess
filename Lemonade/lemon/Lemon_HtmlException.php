<?
/*
* HTML 로 에러를 표시해주는 HtmlException
*/

class Lemon_HtmlException extends Exception
{
	var $comment;

   public function __construct($message, $comment, $code = 0) {
	   $this->comment = $comment;
	   parent::__construct($message, $code);
   }

   public function __toString() {
		$tpl = new Template_;
		$tpl->define(array('index' => "error.html"));
		$tpl->assign(array(
			'ERROR_MSG' => $this->message,
			'COMMENT' => $this->comment
		));
		return $tpl->print_('index').'';
   }
}

?>