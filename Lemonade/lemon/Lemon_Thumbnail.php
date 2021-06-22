<?

/*

* ex> 사용법

* // 저장할 썸네일 명의 디렉토리는 없을 경우 새로 생성함

*

* $th = new Thumbnail("원본파일명(경로포함)","저장할썸네일명(확장자지정안해도됨)");

* $th->setMode('ratio');		// 비율유지, fix - 지정크기로 무조건 리사이즈

* $th->setSize('135','135');	// 사이즈 지정. ratio - 해당 사이즈를 넘지 않는 선에서 비율유지하여 리사이즈

* $th->make();					// 썸네일 생성

*/

class Lemon_Thumbnail {



	public $srcfile = '';

	public $destfile = '';

	public $fileExt = '';



	/*

	* fix - 지정한 사이즈대로 무조건 리사이즈.

	* ratio - 지정한 사이즈를 넘지 않는 범위에서 가장 큰 크기로 비율유지하여 리사이즈

	*/

	public $mode = 'fix';



	public $width = 0;

	public $height = 0;



	function __construct($srcfile='',$destfile=''){

		$this->srcfile = $srcfile;

		$this->destfile = $destfile;

		$this->setFileExt();



		$basename = basename($this->destfile);

		if(strpos($basename,".")===false){

			$this->destfile = $this->destfile.($this->fileExt==''?'':".".$this->fileExt);

		}

	}



	function setFile($srcfile,$destfile){

		$this->__construct($srcfile,$destfile);

	}



	function setFileExt(){

		$this->fileExt=substr(strrchr($this->srcfile,"."),1);

	}



	/*

	* 비율유지/지정크기 리사이즈 결정. 디폴트는 지정크기

	* 2번째 인자값 추가함

	* 2번째 인자값이 없으면 mode 값이 ratio 일때 가로 세로중 큰값을 기준으로 비율로 줄임

	* 2번째 인자값이 있으면 가로 세로중 작은 값을 기준으로 비율로 줄임

	*/

	function setMode($mode){

		$this->mode = $mode;

	}



	function setSize($width,$height){

		$this->width = $width;

		$this->height = $height;

	}



	// 이미지 저장공간 생성

	function makeDirectory($dir){

		$rTmp = explode("/",$dir);



		for($i=0;$i<count(array($rTmp));$i++){

			$tmpDir .= "/".$rTmp[$i];

			if(!is_dir($tmpDir))

				if(mkdir($tmpDir)===false)

					echo " make directory error ! \n";

		}

	}



	function getResizeInfo($srcSize,$width,$height){

		$per = '';



		// 이미지가 정한 사이즈보다 작을 경우 리사이즈 하지 않는다

		if($srcSize[0]<$width && $srcSize[1]<$height){

			$return['width']=ceil($srcSize[0]);

			$return['height']=ceil($srcSize[1]);

		}

		// 한쪽만 정한 사이즈보다 작은 경우 x,y 중 큰쪽을 기준으로 잡는다

		else if($srcSize[0]<$width || $srcSize[1]<$height){

			if($srcSize[0]>$srcSize[1])

				$per = $width/$srcSize[0];

			else

				$per = $height/$srcSize[1];

		}

		// x,y 가 정한 사이즈보다 클 경우,

		// 정한 사이즈와 이미지 사이즈의 x, y 비율을 계산해서

		// 둘중 비율이 큰쪽을 기준으로 잡아야 한다

		else {

			$xRate = round($srcSize[0]/$width,2);

			$yRate = round($srcSize[1]/$height,2);



			if($xRate>$yRate)

				$per = $width/$srcSize[0];

			else

				$per = $height/$srcSize[1];

		}



		if($per!=''){

			$return['width']=ceil($srcSize[0]*$per);

			$return['height']=ceil($srcSize[1]*$per);

		}



		return $return;

	}



	function make(){

		$dir = dirname($this->destfile);

		$this->makeDirectory($dir);



		$this->resizeImage($this->srcfile,$this->destfile,$this->width,$this->height);

	}



	function resizeImage($src,$dest,$width,$height){



		$ext = $this->fileExt;								// 파일 확장자

		$rSourceSize = getimagesize($src);					// 이미지 사이즈 정보 얻기



		if($ext == 'jpg')									// call_user_func 함수쓰기 위해

			$subFuncName = 'jpeg';

		else

			$subFuncName = $ext;



		$func = 'imagecreatefrom'.$subFuncName;				// 이미지 생성 함수명 설정



		$hSResource = call_user_func($func,$src);			// 이미지소스 리소스



		if($this->mode=='ratio'){

			// 비율 유지일 경우 가로,세로 재계산

			$rTmp = $this->getResizeInfo($rSourceSize,$width,$height);

			$width = $rTmp['width'];

			$height = $rTmp['height'];



			//echo "w : $width , h : $height <br>";

		}



		$hDResource = imagecreatetruecolor($width,$height);	// 저장할이미지 리소스



		// 원본 이미지에서 원하는 크기의 새로운 이미지로 샘플링을 함

		if(!imagecopyresampled($hDResource,$hSResource,0,0,0,0,$width,$height,$rSourceSize[0],$rSourceSize[1]))

			echo "==> (makeResizeImage) Image Sampling Error \n";



		// 실제 이미지 생성. jpeg 일 경우 퀄리티를 80으로 해서 생성

		if($ext=='jpg'){

			if(!call_user_func('image'.$subFuncName,$hDResource,$dest,80)){

				echo "==> (makeResizeImage) Thumbnail $subName Error \n";

			}

		}

		else {

			if(!call_user_func('image'.$subFuncName,$hDResource,$dest)){

				echo "==> (makeResizeImage) Thumbnail $subName Error \n";

			}

		}



		imagedestroy($hDResource);

		imagedestroy($hSResource);

	}

}

?>