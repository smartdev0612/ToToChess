<?php 


class TeamController extends WebServiceController 
{
	//▶ 팀 목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/team/list.html");
		
		$model  	= $this->getModel("TeamModel");
		$nationModel  	= $this->getModel("NationModel");
        $leagueModel = $this->getModel("LeagueModel");
		
		$act		= $this->request("act");
		$category	= empty($this->request("category")) ? "" : $this->request("category");
		$nation_sn	= empty($this->request("nation_sn")) ? 0 : $this->request("nation_sn");
		$keyword 	= empty($this->request("team_name")) ? "" : $this->request("team_name");

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

		$where = "";
		
		if($keyword != "")
			$where .= " and tb_team.Team_Name_Kor like '%" . $keyword . "%'";

		if($category != "")	
			$where .= " and tb_team.Sport_Name = '" . $category . "'";	

		if($nation_sn != 0)
			$where .= " and tb_team.Location_Id = " . $nation_sn;

			
		$page_act= "team_name=".$keyword."&category=".$category."&nation_sn=".$nation_sn;
		
		$total 			= $model->getTotal($where);
        
		$pageMaker 	= $this->displayPage($total, 40, $page_act);
		$list 			= $model->getList($where, $pageMaker->first, $pageMaker->listNum);
		$categoryList = $leagueModel->getCategoryList();
		$nationList = $nationModel->getNationList();
        
		$this->view->assign('category', $category);
		$this->view->assign('team_name', $keyword);
		$this->view->assign('category_list', $categoryList);
		$this->view->assign('nation_sn', $nation_sn);
		$this->view->assign('nation_list', $nationList);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	//▶ 팀 추가
	function popup_addAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$teamModel = $this->getModel('LeagueModel');
		$categoryList = $teamModel->getCategoryList();
		
		$this->view->define("content","content/team/popup.add.html");
		
		$this->view->assign('category_list',$categoryList);
		$this->display();
	}

	//▶ 팀 편집
	function popup_editAction() {
		$this->popupDefine();
	
		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/team/popup.edit.html");
			
		$teamModel = $this->getModel("TeamModel");
		$nationModel  	= $this->getModel("NationModel");
        $leagueModel = $this->getModel("LeagueModel");
		$teamSn = empty($this->request("team_sn")) ? 0 : $this->request("team_sn");
		$mode = trim($this->request("mode"));
				
		if ( $mode == "edit" ) {	
			$teamSn = empty($this->request("team_sn")) ? 0 : $this->request("team_sn");
			$name = $this->request("team_name");

			$teamModel->modify($teamSn, $name);
			if ( $_FILES["upLoadFile"]["size"] > 0 and $_FILES["upLoadFile"]["error"] == 0 ) {
				$uploadImgUrl = $this->teamImgUpload($teamSn, $_FILES["upLoadFile"]);
				if ( $uploadImgUrl ) {
					$teamModel->updateTeamImg($teamSn, $uploadImgUrl);
				}
			}
			throw new Lemon_ScriptException("","","script","alert('수정 되였습니다.');opener.document.location.reload(); self.close();");
		} else {
			$item = $teamModel->getListBySn($teamSn);
		}	

		$categoryList = $leagueModel->getCategoryList();
		$nationList = $nationModel->getNationList();
		
		$this->view->assign('category_list',$categoryList);
		$this->view->assign('nation_list',$nationList);
		$this->view->assign('team_sn', $teamSn);
		$this->view->assign('item', $item);
		
		$this->display();
	}

	//-> 팀 이미지 업로드 (이미지서버)
    function teamImgUpload($teamSn, $FILES) {
        //-> ini 파일에 파일 저장 경로 정보 가져옴.
        /*$uploadInfo = Lemon_Configure::readConfig('config');
        $upload_sitecode = $uploadInfo['site']['site_code'];
        $upload_domain = $uploadInfo['site']['file_domain'];
        $upload_ip = $uploadInfo['ftp']['ip'];
        $upload_port = $uploadInfo['ftp']['port'];
        $upload_user = $uploadInfo['ftp']['user'];
        $upload_passwd = $uploadInfo['ftp']['passwd'];*/
        $img_dir = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.user\\upload\\team\\";
        $img_dir2 = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\vhost.manager\\upload\\team\\";
		$img_dir3 = "C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\m.vhost.user\\upload\\team\\";

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
            $fileName = "t_".time().".".$fileTypeName;

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

        $imgsrc = "/upload/team"."/".$fileName;
        return $imgsrc;
    }
}

?>