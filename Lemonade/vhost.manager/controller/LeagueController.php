<?php 


class LeagueController extends WebServiceController 
{
	//▶ 리그 목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/league/list.html");
		
		$model  	= $this->getModel("LeagueModel");
		
		$act		 	= $this->request("act");
		$category	= $this->request("category");
		
		$ph_path		 = "";
		$new_ph_path = "../vhost.user";
		
		if($act=="del")
		{
			$arrmemidx = $this->request("y_id");
			
			$str="";
	
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			
			$str=substr($str,0,strlen($str)-1);
			
			$model->delProcess($str);
		}
		else if($act=="delete")
		{
			$idx = $this->request("idx");
			if($idx=="")
				throw new Lemon_ScriptException("","","script","history.back();");
			
			$model->delProcess($idx);
		}
		
		$keyword = $this->request("username");
		
		//keyword
		if($keyword!="")										$where.= " name like '%".$keyword."%'";
		
		if($keyword!="" && $category!="")		$where.= " and kind='".$category."'";
		else if($category!="")							$where.= " kind='".$category."'";

		$conf = Lemon_Configure::readConfig('config');
		if($conf['site']!='')
			$UPLOAD_URL = $conf['site']['upload_url'];
			
		$page_act= "username=".$keyword."&category=".$category;
		
		$total 			= $model->getTotal($where);
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $model->getList($where, $pageMaker->first, $pageMaker->listNum);
		
		$categoryList = $model->getCategoryList();
		
		$this->view->assign('category', $category);
		$this->view->assign('username', $keyword);
		$this->view->assign('category_list', $categoryList);
		$this->view->assign('UPLOAD_URL', $UPLOAD_URL);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	//▶ 리그 추가
	function popup_addAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$leagueModel = $this->getModel('LeagueModel');
		$categoryList = $leagueModel->getCategoryList();
		
		$this->view->define("content","content/league/popup.add.html");
		
		$this->view->assign('category_list',$categoryList);
		$this->display();
	}

	//▶ 리그 추가 처리
	function addProcessAction() {
		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		
		$leagueModel = $this->getModel('LeagueModel');
		
		$category = $this->request('category');
		$league = $this->request('league_name');
		$nationSn = empty($this->request('nation_sn')) ? 0 : $this->request('nation_sn');
		$uploadFile = $_FILES["upLoadFile"];

		$insertSn = $leagueModel->add($category, $league, $nationSn);
		if ( $_FILES["upLoadFile"]["size"] > 0 and $_FILES["upLoadFile"]["error"] == 0 ) {
			$uploadImgUrl = $this->leagueImgUpload($insertSn, $_FILES["upLoadFile"]);
			if ( $uploadImgUrl ) {
				$leagueModel->updateLeagueImg($insertSn, $uploadImgUrl);
			}
		}

		throw new Lemon_ScriptException("","","script","alert('추가 되였습니다.');opener.document.location.reload(); self.close();");
	}

	//▶ 리그 편집
	function popup_editAction() {
		$this->popupDefine();
	
		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/league/popup.edit.html");
			
		$leagueModel = $this->getModel("LeagueModel");
		$leagueSn = $this->request("league_sn");
		$mode = trim($this->request("mode"));
				
		if ( $mode == "edit" ) {	
			$leagueSn = $this->request("league_sn");
			$before_kind = $this->request("before_kind");
			$kind = $this->request("league_kind");
			$name = $this->request("league_name");
			$alias = $this->request("alias_league_name");
			$nationflag = $this->request("nationflag");
			$viewStyle = $this->request("view_style");
			$linkUrl = $this->request("link_url");

			$leagueModel->modify($leagueSn, $kind, $name, $viewStyle, $linkUrl, $alias);
			if ( $_FILES["upLoadFile"]["size"] > 0 and $_FILES["upLoadFile"]["error"] == 0 ) {
				$uploadImgUrl = $this->leagueImgUpload($leagueSn, $_FILES["upLoadFile"]);
				if ( $uploadImgUrl ) {
					$leagueModel->updateLeagueImg($leagueSn, $uploadImgUrl);
				}
			}

			//-> 리그의 종목을 변경하면 경기 데이타의 종목명도 함께 변경해준다.
			if ( $before_kind != $kind ) {
				$leagueModel->modify_league_kind($leagueSn, $before_kind, $kind);
			}
			throw new Lemon_ScriptException("","","script","alert('수정 되였습니다.');opener.document.location.reload(); self.close();");
		} else {
			$item = $leagueModel->getListBySn($leagueSn);
				
			$nationCode = $item['nation_sn'];
			$item['nation_image'] = $leagueModel->getNationImage($nationCode);
		}	

		$categoryList = $leagueModel->getCategoryList();
		
		$this->view->assign('SITE_DOMAIN', $SITE_DOMAIN);
		$this->view->assign('UPLOAD_URL', $UPLOAD_URL);
		$this->view->assign('category_list',$categoryList);
		$this->view->assign('league_sn', $leagueSn);
		$this->view->assign('item', $item);
		
		$this->display();
	}

	//-> 리그 이미지 업로드 (이미지서버)
    function leagueImgUpload($leagueSn, $FILES) {
        //-> ini 파일에 파일 저장 경로 정보 가져옴.
        /*$uploadInfo = Lemon_Configure::readConfig('config');
        $upload_sitecode = $uploadInfo['site']['site_code'];
        $upload_domain = $uploadInfo['site']['file_domain'];
        $upload_ip = $uploadInfo['ftp']['ip'];
        $upload_port = $uploadInfo['ftp']['port'];
        $upload_user = $uploadInfo['ftp']['user'];
        $upload_passwd = $uploadInfo['ftp']['passwd'];*/
        $img_dir = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.user\\upload\\league\\";
        $img_dir2 = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.manager\\upload\\league\\";
		$img_dir3 = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\m.vhost.user\\upload\\league\\";

        //-> 파일 사이즈 체크. (최대 2MB
        if ( $FILES["size"] > 2000000 ) {
            throw new Lemon_ScriptException("첨부 파일 용량은 최대 2메가 입니다.","","back");
            exit;
        }

        //-> 파일 확장자 체크.
        $imgCheckType = array("^","image/jpeg","image/jpg","image/gif","image/png");
        if ( array_search($FILES["type"], $imgCheckType) > 0 ) {

            //-> 파일에 확장자 추출.
            $fileType = explode(".",$FILES["name"]);
            $fileTypeName = $fileType[count($fileType)-1];

            //-> 파일명은 년월일시분초
            $fileName = "lg_".time().".".$fileTypeName;

            /*$fp = fopen($FILES['tmp_name'], 'r');
            $conn_id = ftp_connect($upload_ip, $upload_port);

            $login_result = ftp_login($conn_id, $upload_user, $upload_passwd);
            ftp_chdir($conn_id, $upload_sitecode);*/

            //if ( !ftp_fput($conn_id, $fileName, $fp, FTP_BINARY) )
            if (is_dir($img_dir) && is_writable($img_dir))
            {
                if ( ! move_uploaded_file($FILES["tmp_name"] , $img_dir . $fileName))
                {
                    throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                    exit;
                }
            }
            else
            {
                throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
                exit;
            }

            copy($img_dir . $fileName, $img_dir2 . $fileName);
            copy($img_dir . $fileName, $img_dir3 . $fileName);
            /*ftp_close($conn_id);
            fclose($fp);*/
        } else {
            throw new Lemon_ScriptException("jpg, gif, png 파일만 업로드 가능합니다.","","back");
            exit;
        }

        $imgsrc = "/upload/league"."/".$fileName;
        return $imgsrc;
    }
	/*function leagueImgUpload($leagueSn, $FILES) {
		//-> ini 파일에 파일 저장 경로 정보 가져옴.
		$uploadInfo = Lemon_Configure::readConfig('config');
		$upload_sitecode = $uploadInfo['site']['site_code'];
		$upload_domain = $uploadInfo['site']['file_domain'];
		$upload_ip = $uploadInfo['ftp']['ip'];
		$upload_port = $uploadInfo['ftp']['port'];
		$upload_user = $uploadInfo['ftp']['user'];
		$upload_passwd = $uploadInfo['ftp']['passwd'];

		//-> 파일 사이즈 체크. (최대 2MB
		if ( $FILES["size"] > 2000000 ) {
			throw new Lemon_ScriptException("첨부 파일 용량은 최대 2메가 입니다.","","back");
			exit;
		}

		//-> 파일 확장자 체크.
		$imgCheckType = array("^","image/jpeg","image/jpg","image/gif","image/png");
		if ( array_search($FILES["type"], $imgCheckType) > 0 ) {

			//-> 파일에 확장자 추출.
			$fileType = explode(".",$FILES["name"]);
			$fileTypeName = $fileType[count($fileType)-1];

			//-> 파일명은 년월일시분초
			$fileName = "lg_".time().".".$fileTypeName;

			$fp = fopen($FILES['tmp_name'], 'r');
			$conn_id = ftp_connect($upload_ip, $upload_port);
			
			$login_result = ftp_login($conn_id, $upload_user, $upload_passwd);  
			ftp_chdir($conn_id, $upload_sitecode);

			if ( !ftp_fput($conn_id, $fileName, $fp, FTP_BINARY) ) {  
				throw new Lemon_ScriptException("파일 업로드를 실패 했습니다. 관리자에게 문의해주세요.","","back");
				exit;
			}

			ftp_close($conn_id);  
			fclose($fp);
		} else {
			throw new Lemon_ScriptException("jpg, gif, png 파일만 업로드 가능합니다.","","back");
			exit;
		}

		$imgsrc = $upload_domain."/".$upload_sitecode."/".$fileName;
		return $imgsrc;
	}*/
	
	//▶ 국가 리스트
	function popup_nationlistAction()
	{
		$this->popupDefine();
	
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/league/popup.nation_list.html");
			
		$model  	= $this->getModel("LeagueModel");
			
		$conf = Lemon_Configure::readConfig('config');
			
		if($conf['site']!='') {$UPLOAD_URL = $conf['site']['upload_url'];}
			
		$idx 	= $this->request("idx");
		$mode	= Trim($this->request("mode"));
			
		if($mode=="") {$mode = "list";}
		
		if($mode=="list") {$list = $model->getNationList();}
		else if($mode=="link")
		{
			$name = $this->request("emblemname");
			$list = $model->getNationByName($name);
		}
	
		$this->view->assign('UPLOAD_URL', $UPLOAD_URL);
		$this->view->assign('name', $name);
		$this->view->assign('list', $list);
		$this->display();
	}
	
	function ajaxLeagueListAction()
	{
		$category = $this->request("category");
		$leagueModel = $this->getModel("LeagueModel");
		
		if($category!='')
			$where = "kind='".$category."'";
		$leagueModel->ajaxList($where);
	}
	
	function copyFile($leagueImage='')
	{
		$conf = Lemon_Configure::readConfig('config');
		if($conf['site']!='')
		{
			$srcUri		= $conf['site']['local_upload_url']."";
			$dstUri 	= $conf['site']['upload_path']."";
			$dstUri_f = $conf['site']['upload_path_f']."";
		}

		if($leagueImage!='')
		{
			if(file_exists($srcUri.$leagueImage) && file_exists($dstUri.$leagueImage))
			{	
				unlink($srcUri.$leagueImage);
				unlink($dstUri.$leagueImage);
			}
		}
		
		$obj = new upload;
		$obj->ph_path = $srcUri;
		$obj->get_ph_tmpname($_FILES['upLoadFile']['tmp_name']);
		$obj->get_ph_type($_FILES['upLoadFile']['type']);
		$obj->get_ph_size($_FILES['upLoadFile']['size']);
		$obj->get_ph_name($_FILES['upLoadFile']['name']);
		$obj->save();
		
		$image = substr($obj->ph_name, strlen($srcUri));
		
		if(!copy($srcUri.$image, $dstUri.$image))
		{
			throw new Lemon_ScriptException("복사오류입니다. 관리자에게 문의해 주세요. #1");					
			exit;
		}
		
		if(!copy($srcUri.$image, $dstUri_f.$image))
		{
			throw new Lemon_ScriptException("복사오류입니다. 관리자에게 문의해 주세요. #2");					
			exit;
		}
		
		return $image;
	}
	
	function category_listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/league/category_list.html");
		
		$act = $this->req->request("act");
		$leagueModel = $this->getModel("LeagueModel");
		
		if($act=="modify")
		{
			$categorySn 	= $this->request("category_sn");
			$categoryName = $this->request("modify_name");
			$leagueModel->modifyCategory($categorySn, $categoryName);
		}
		else if($act=="delete")
		{
			$categorySn	= $this->request("category_sn");
			if($categorySn!="")
				$leagueModel->deleteCategory($categorySn);
		}
		
		$list = $leagueModel->getCategoryList();
		
		$this->view->assign('list', $list);
		
		$this->display();
	}
}

?>