<?
/**
* 파일 처리를 위한 클래스
* 중복파일이 있을 경우 파일명뒤에 "_" 를 추가하여 중복피하여 업로드함
* setOverwrite() 메소드를 통해 덮어쓰기를 할 수 있음
*/

class Lemon_FileUpload {

	private $srcFile;		// $_FILES["xxx"]
	private $saveFile;		// 경로를 포함한 저장될 파일명
	private $fileExt;		// 파일 확장자
	private $isOverwrite = false;	// 중복 파일 있을 경우 덮어쓸지 여부. 기본값은 덮어쓰지 않음.

	function __construct($srcFile='',$saveFile=''){
		$this->srcFile = $srcFile;
		$this->saveFile = $saveFile;
		$this->setFileExt();
	}

	function setFile($srcFile,$saveFile){
		$this->__construct($srcFile,$saveFile);
	}

	function getSaveFile(){
		return $this->saveFile;
	}

	function setOverwrite(){
		$this->isOverwrite = true;
	}

	/**
	* 파일 확장자 찾기
	*/
	function setFileExt(){
		$file=(is_array($this->srcFile)?$this->srcFile['name']:$this->srcFile);
		$this->fileExt=strtolower(substr(strrchr($file,"."),1));
	}


	// 파일 확장자 ;
	function getFileExt(){
		return $this->fileExt;
	}

	/*
	* 디렉토리 생성
	*/
	function makeDir($file){
		// 윈도우에서 작동시를 위해 c:, d: 이런걸 우선 제거하고 explode 를 한다
		$file = str_replace($path['baseDir'],'',$file);
		$arrDir = explode("/",preg_replace("/^[c-z]:/",'',$file));

		if(count((array)$arrDir)>=1){
			for($i=0;$i<count((array)$arrDir)-1;$i++){
				if($i==0 && $arrDir[$i]=='')	continue;

				if(!is_dir("/".($dir==''?'':$dir."/").$arrDir[$i])){
					//echo "dir : " . "/".$dir."/".$arrDir[$i] . "<br>";
					if(!mkdir("/".$dir."/".$arrDir[$i])){
						throw new Lemon_ScriptException("Error : 업로드실패","디렉토리를 생성할 수 없습니다. 권한을 체크해보세요",'alert');
					}
				}
				$dir .= ($dir!=''?"/":''). $arrDir[$i];
			}
		}

		return $dir;
	}

	function upload(){
		try{
			$obj = $this->makeDir($this->saveFile);
			if(is_a($obj,'Lemon_ScriptException'))
				return $obj;

			$basename = basename($this->saveFile);
			if(strpos($basename,".")===false){
				$this->saveFile = $this->saveFile.($this->fileExt==''?'':".".$this->fileExt);
			}

			if(file_exists($this->saveFile)){
				if(!$this->isOverwrite)
					$this->saveFile = substr($this->saveFile,0,strrpos($this->saveFile,"/")+1).str_replace(".","_.",basename($this->saveFile));
			}

			// 테스트용
			//$this->saveFile = "/home/httpd/vhost.koreandb_new/upload/".$this->srcFile['name'];

			if(!move_uploaded_file($this->srcFile['tmp_name'],$this->saveFile)){
				throw new Lemon_ScriptException("Error : 업로드실패","파일업로드에 실패했습니다. 업로드파일의 경로 또는 권한을 체크해보세요",'back');
			}
		}
		catch(Lemon_ScriptException $e){
			echo $e;
			exit;
		}
	}
}
?>