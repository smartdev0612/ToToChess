<?
/*
* 페이지 처리를 위한 클래스
* 각 '이전', '다음', '현재페이지', '다른 페이지', '처음', '마지막' 에 대한 icon 또는 css 를 따로 지정 가능하다.
* 배열로 지정하되 파일로 pageicon.ini 파일을 만들어 지정하면 편하다.
* 지정 방법은 pageicon.ini 에
* first = "<<";
* before = "<";
* currentPage = "<b> [%d] </b>";
* otherPage = "[%d]";
* next = ">";
* last = ">>";
* separator = " ";	# 번호사이 구분자
*/
class Lemon_Page {

	public $page = 1;
	public $url = '';
	public $listNum = 10;
	public $pageNum = 10;
	public $first = 0;
	public $totalPage = 0;
	public $icon = null;
	public $rownum = 0;

	/*
	* page.ini 파일에 지정한 내용중 지정하고픈 아이콘 모음의 키를 지정한다.
	*/
	public function setIcon($icon){
		$conf = Lemon_Configure::readConfig('page');
		
		if($conf[$icon]!='')
			$this->icon = $conf[$icon];
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function setListNum($num){
		$this->listNum = $num;
	}

	public function setPageNum($num){
		$this->pageNum = $num;
	}

	public function setPage($page,$totalCnt){
		$this->page = ($page==''?1:$page);

		if($totalCnt == 0){
			$this->totalPage = 1;
			$this->first = 0;
		}
		else {
			$this->totalPage = ceil($totalCnt/$this->listNum);
			$this->first = ($this->listNum)*($this->page-1);
		}

		$this->rownum = $totalCnt - ($this->listNum)*($this->page-1);
	}

	/**
	* 페이지리스트 만들어주는 메소드
	*
	* @param $page 현재페이지
	* @param $totalCnt 총 페이지수 
	* @param $var 링크에 붙일 변수들
	*/
	public function pageList($addVar='',$script=''){
		$totalBlock = ceil($this->totalPage/$this->pageNum);
		$block = ceil($this->page/$this->pageNum);
		$firstPage = ($this->pageNum)*($block-1); 
		$lastPage = ($this->pageNum)*$block;

		if($block == $totalBlock)
			$lastPage = $this->totalPage;
			
		if($this->icon=='')
		{
			//$this->setIcon('default');
			
			if($this->icon=='')
			{
				$this->icon=array(
				            'first'=>"≪",
							'before'=>"◀",
							'currentPage'=>"<b style='color: #3e9bfd;'> [%d] </b>",
							'otherPage'=>"[%d]",
							'next'=>"▶",
							'last'=>"≫",
							'separator'=>" ");
			}
		}

		if($this->url!='')
			$requestUri = "http://".$_SERVER['HTTP_HOST']."/".$this->url;
		else 
		{
			if(strpos($_SERVER['REQUEST_URI'],"?"))
				$requestUri = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"?"));
			else
				$requestUri = $_SERVER['REQUEST_URI'];
		}

		if($script=='script')
			$url = "javascript:_Page('".$requestUri."','".$addVar."','%d')";
		else
			$url = $requestUri."?page=%d".($addVar!=''?"&".$addVar:'');

		if($block>1 && $totalBlock>1)
		{
			if($this->icon['first']!='')
			{
				$pageView['beforePage'] = ($this->icon['firstStartTag']!=''?$this->icon['firstStartTag']:'')." <a href=\"".str_replace("%%","%",sprintf($url,1))."\" title='맨처음'>".$this->icon['first']."</a>"."<a href=\"".str_replace("%%","%",sprintf($url,$firstPage))."\" title='이전'>".$this->icon['before']."</a>".($this->icon['firstEndTag']!=''?$this->icon['firstEndTag']:'');
			}
			else {
                $pageView['beforePage'] = ($this->icon['beforeStartTag']!=''?$this->icon['beforeStartTag']:'')."<a href=\"".str_replace("%%","%",sprintf($url,$firstPage))."\" title='이전'>".$this->icon['before']."</a>".($this->icon['beforeEndTag']!=''?$this->icon['beforeEndTag']:'');
            }
		}

		for($i=$firstPage+1;$i<=$lastPage;$i++)
		{
			if($this->page == $i)
			{
				$pageView['pageList'] .= sprintf($this->icon['currentPage'],$i);
			} 
			else 
			{
				if($this->icon['otherPageStartTag']!=''){
					$pageView['pageList'] .= $this->icon['otherPageStartTag'];
				}
				
				$pageView['pageList'] .= "<a href=\"".str_replace("%%","%",sprintf($url,$i))."\">".sprintf($this->icon['otherPage'],$i)."</a>";
				
				if($this->icon['otherPageEndTag']!=''){
					$pageView['pageList'] .= $this->icon['otherPageEndTag'];
				}
			}
			if($firstPage < $i && $lastPage > $i){
				$pageView['pageList'] .= $this->icon['separator'];
			}
		}

		if($this->icon['pagelistStartTag']!=''){
			$pageView['pageList'] = $this->icon['pagelistStartTag'].$pageView['pageList'].$this->icon['pagelistEndTag'];
		}

		if($block<$totalBlock)
		{
			$pageView['nextPage'] = ($this->icon['nextStartTag']!=''?$this->icon['nextStartTag']:'')."<a href=\"".str_replace("%%","%",sprintf($url,($lastPage+1)))."\" title='다음'>".$this->icon['next']."</a>".($this->icon['nextEndTag']!=''?$this->icon['nextEndTag']:'');

			if($this->icon['last']!='')
			{
				$pageView['nextPage'] .= ($this->icon['lastStartTag']!=''?$this->icon['lastStartTag']:'')." <a href=\"".str_replace("%%","%",sprintf($url,$this->totalPage))."\" title='맨마지막'>".$this->icon['last']."</a>".($this->icon['lastEndTag']!=''?$this->icon['lastEndTag']:'');
			}
		}

		$return = $pageView['beforePage'] . " " . $pageView['pageList'] . " " . $pageView['nextPage'];

		if($this->icon['allStartTag']!='')
			$return = $this->icon['allStartTag'] . $return;
		
		if($this->icon['allEndTag']!='')
			$return = $return . $this->icon['allEndTag'];
			
		return $return;
	}

	/*
	* 스크립트 형식으로 페이지를 이동시킬때 사용
	* 특정 스크립트 처리후 페이지 이동이 필요할 때 사용
	* 스크립트 상에 _Page() 라는 자바스크립트가 반드시 필요
	*
	* function _Page(requesturi,addvar,page){
	*	var url = requesturi+"?"+addvar+(addvar!=""?"&":"")+"page="+page;
	*	goPage(url);
	* }
	*
	* goPage 함수만 만들어서 사용하면 됨
	*
	*/
	public function pageListJavascript($addVar=''){
		return $this->pageList($addVar='','script');
	}
}