<?php 
/*======================================
사이트루드상대경로, 사이트디스크경로               
   ======================================*/

$config_site_root="/manager"; 

/*======================================
사이트루드상대경로, 사이트디스크경로               
   ======================================*/

$db_qz="tb_";
$logo="totobang";     //网站标识，与web页面的大小写保持一至
$is_stop_time="30";  //event比赛30分钟前停止押注

/*======================================
이미지경로
======================================*/

$config_image_root="http://192.168.1.99:89/images/";

/*======================================
업로드폴더 유저페이지와 관리자 페이지가 분리 되였을때 절대경로 위지윅에디터에 사용할 변수
======================================*/

//$config_upload_root="C:/xampp/htdocs/black/vhost.user/";
$config_upload_root="C:/xampp/htdocs/gadget/www_gadget_o2_lsports.com/vhost.user/";

//$config_upload_url="http://black.com/";//메인페이지 주소 / 를 무조건 달아줌
$config_upload_url="https://line1111.com/";//메인페이지 주소 / 를 무조건 달아줌

/*======================================
사이트도메인
======================================*/

$config_site_domain="http://192.168.1.99:89/";

/*======================================
인젝션 방지 프로그램 주소
======================================*/

//$config_injection_domain="";

/*======================================
사이트이름
======================================*/

$config_site_name="토토방";

/*======================================
사이트타이틀
======================================*/

$config_site_title="행운의 토토방 - 관리자";

/*======================================
사이트상태바
======================================*/

$config_site_status="토토 사이트 상태";

/*======================================
프리사이트도메인
======================================*/

$config_free_site="http://192.168.1.99:89/";

/*======================================
ftp 设置 多台服务器同步而用（上传图片到多台服务器）
======================================*/
$config_ftp_open="0";//开启ftp上传图片 0为关闭 1为开启
$config_ftp_ip="219.117.246.229";//远程ftp 地址
$config_ftp_port="5454";//ftp端口
$config_ftp_user="up_file";//ftp帐号
$config_ftp_pass="woshishui";//ftp密码

//======================================

define("SITE_ROOT",$config_site_root);  //网站根目录
define("IMAGE_ROOT",$config_image_root);//图片目录
define("UPLOAD_ROOT",$config_upload_root);//上传文件夹
define("SITE_DOMAIN",$config_site_domain);//域名
define("SITE_NAME",$config_site_name);//网站名称
define("SITE_TITLE",$config_site_title);//网站TITLE
define("FREE_SITE",$config_free_site);//
define("IS_STOP_TIME",$is_stop_time);

?>