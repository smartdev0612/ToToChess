
	<div class="mask"></div>
	<div id="container">

	<style type="text/css">
		.m_padding  { PADDING-LEFT: 12px; PADDING-BOTTOM: 2px; PADDING-TOP: 2px;}
		.m_padding2 { PADDING-LEFT: 0px; PADDING-top: 5px; PADDING-BOTTOM: 0px; }
		.m_padding3 { PADDING-LEFT: 0px; PADDING-top: 5px; PADDING-BOTTOM: 5px; }
		.reg_tb{border:1px #333 solid;}
		.ed { background-color:#fff; color:#000;border:1px solid #ddd;width:358px; padding-left:10px; height:40px;}
		.edh { background-color:#fff; color:#000;border:1px solid #ddd;width:109px; padding-left:10px; height:40px;}

		.pn { -webkit-text-security: disc; -moz-text-security:circle; text-security:circle; }
		.pn::-webkit-inner-spin-button, .pn::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
	</style>
	<script type="text/javascript">
		var recode = '<?=$_SESSION["recode"]?>';
		var partnerSn = '<?php echo $TPL_VAR["partnerSn"]?>';
		var recommendUid = '<?php echo $TPL_VAR["recommendUid"]?>';
		var parentCodeFlag = 0;
		var submitFlag = 0;
	</script>
	
	<div id="contents">
		<div class="board_box">
			<h2>회원가입</h2>
			<!-- 회원가입 폼 -->
			<div class="member_section">
				<div class="member_box">
					
					<div class="box01" style="width:100%">
						<!-- 입력 박스 -->
						<div class="input_area" >
							<div class="box_left">
								<div class="userbox" style="display:flex;">
									<h3>사용자 아이디</h3><button type="button" class="checkBtn" onclick="checkDuplicatedID()">중복아이디 체크</button>
								</div>
								<div class="input_box">
									<input type="text" id="userid" name="userid"/>
									<p>영문자, 숫자만 입력 가능, 최소 3자이상 입력하세요.</p>
								</div>
							</div>
							<div class="box_left">
								<div class="userbox" style="display:flex;">
									<h3>닉네임</h3><button type="button" class="checkBtn" onclick="checkDuplicatedNickName()">중복닉네임 체크</button>
								</div>
								<div class="input_box">
									<input type="text" id='nick' name='nick'/>
									<p>한글만 등록이 가능합니다.</p>
								</div>
							</div>
						</div>
						<div class="input_area">
							<div class="box_left">
								<h3>비밀번호</h3>
								<div class="input_box">
									<input type="password" id="upass" name="upass"/>
									<p>영문/숫자 그리구 특수문자 ( ex : ! @ # $ % ^ & ) 를 한자이상 반드시 포함하여 6~16자로 입력하세요.</p>
								</div>
							</div>
							<div class="box_left">
								<h3>비밀번호 확인</h3>
								<div class="input_box">
									<input type="password" id="confirm_upass" name="confirm_upass"/>
								</div>
							</div>
						</div>
						<div class="input_area">
							<div class="box_left">
								<h3>계좌정보</h3>
								<div class="input_box">
									<span class="select_box">
										<select id="bank_name" name="bank_name">
											<option value="국민은행">국민은행</option>
											<option value="광주은행">광주은행</option>
											<option value="경남은행">경남은행</option>
											<option value="기업은행">기업은행</option>
											<option value="농협">농협</option>
											<option value="대구은행">대구은행</option>
											<option value="도이치은행">도이치은행</option>
											<option value="부산은행">부산은행</option>
											<option value="상호저축은행">상호저축은행</option>
											<option value="새마을금고">새마을금고</option>
											<option value="수협">수협</option>
											<option value="신협">신협</option>
											<option value="신한은행">신한은행</option>
											<option value="외환은행">외환은행</option>
											<option value="우리은행">우리은행</option>
											<option value="우체국">우체국</option>
											<option value="전북은행">전북은행</option>
											<option value="제주은행">제주은행</option>
											<option value="하나은행">하나은행</option>
											<option value="한국씨티은행">한국씨티은행</option>
											<option value="HSBC은행">HSBC은행</option>
											<option value="SC제일은행">SC제일은행</option>
											<option value="카카오뱅크">카카오뱅크</option>
											<option value="K뱅크">K뱅크</option>
										</select>
									</span>
									<input type="text" id="bank_account" name="bank_account" placeholder="계좌번호" class="right01"/>
									<p>충/환전시 빠른 처리가 이루어 질 수 있도록,<br/>본인 명의와 올바른 계좌정보를 입력해 주시기 바랍니다.</p>
								</div>
							</div>
							<div class="box_left">
								<h3>예금주</h3>
								<div class="input_box">
									<input type="text" id="bank_member" name="bank_member"/>
								</div>
							</div>
						</div>
						<div class="input_area">
							<div class="box_left" style="width:100%;">
								<h3>충환전비밀번호</h3>
								<div class="input_box">
									<input type="text" id="exchange_pass" name="exchange_pass"/>
								</div>
							</div>
						</div>
						<div class="input_area">
							<div class="box_left">
								<h3>연락처</h3>
								<div class="input_box">
									<span class="select_box">
										<select id="phone1" name="phone1">
											<option>010</option>
											<option>011</option>
											<option>016</option>
											<option>017</option>
											<option>018</option>
											<option>019</option>
										</select>
									</span>
									<input type="text" id="phone2" name="phone2" class="right01" style="width:64%"/>&nbsp;
								</div>
							</div>
						</div>
						<div class="input_area">
							<div class="box_left" style="float:none;margin:0 auto;">
								<div class="btn_join">
									<button type="button" onClick="joinAction();">회원가입</button>
									<button type="button" onClick="location.href='/';">취소</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<link rel="stylesheet" type="text/css" href="/10bet/css/10bet/swiper.min.css" />
<script type="text/javascript" src="/10bet/js/10bet/swiper.min.js"></script>
<script type="text/javascript" src="/include/js/join.js?v=<?php echo time();?>"></script>
<script>
var swiper = new Swiper('.member_rolling', {
	loop: true,
	autoplay: {
		delay: 4000,
		disableOnInteraction: false,
      },
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},
});
</script>
