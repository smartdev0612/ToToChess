<?php /* Template_ 2.2.3 2014/10/16 22:09:39 D:\www_kd_20140905\vhost.manager\_template\content\content.index.html */?>
<div id="route">
		<h5>관리자메인</h5>
	</div>
	<h3>관리자메인</h3>

	<table cellspacing="1" class="tableStyle_normal">
	<thead>
		<tr>
			<th scope="col" class="id">아이디</th>
			<th scope="col">닉네임</th>
			<th scope="col">상위총판</th>
			<th scope="col">경로</th>
			<th scope="col">도메인</th>
			<th scope="col">아이피</th>
			<th scope="col">일주일간 접속횟수</th>
			<th scope="col">일주일간 충전금액</th>
			<th scope="col">일주일간 출금금액</th>
			<th scope="col">일주일간 당첨금액</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_VAR["list"]["member_sn"]?>',1024,580)"><?php echo $TPL_VAR["list"]["uid"]?></td>
			<td><?php echo $TPL_VAR["list"]["nick"]?></td>
			<td><?php echo $TPL_VAR["list"]["logo"];?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
	<div id="search" class="topmargin">
		<div class="wrap">
			<span class="icon">이름</span>
			<input name="" type="text" id="" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20"/>
			<span class="icon">당첨금액</span>
			<input name="" type="text" id="" class="normal" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20"/>이상 <input name="" type="text" id="" class="normal" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20"/>이하
			<input name="Submit4" type="image" src="/img/btn_search.gif"/>
		</div>
	</div>

	<div id="" class="result_section">
		<h4>검색결과</h4>
		<table cellspacing="1" class="tablestyle_info">
			<tr>
				<th>아이디</th><td>1</td>
				<th>당첨금액</th><td>1<span>(단폴더 당첨금액 : )</span></td>
			</tr>
			<tr>
				<th>닉네임</th><td>1</td>
				<th>낙첨금액</th><td>1<span>(단폴더 낙첨금액 : )</span></td>
			</tr>
			<tr>
				<th>등급</th><td>1</td>
				<th>충전금액</th><td>1</td>
			</tr>
			<tr>
				<th>총베팅액</th><td>1</td>
				<th>출금금액</th><td>1</td>
			</tr>
			<tr>
				<th>전화번호</th><td>1</td>
				<th>당첨금액</th><td>1</td>
			</tr>
			<tr>
				<th>총판</th><td>1</td>
				<th>충전보너스 지급액</th><td>1</td>
			</tr>
			<tr>
				<th>보유금액</th><td>2</td>
				<th>낙첨보너스 지급액</th><td>1</td>
			</tr>
			<tr>
				<th>보유마일리지</th><td>2</td>
				<th class="none"></th><td></td>
			</tr>
			<tr>
			</tr>
			<tr>
			</tr>
		</table>
		<table cellspacing="1" class="tableStyle_normal">
		<thead>
			<tr>
				<th scope="col" colspan="5">현재 베팅내역(5만원)</th>
				<th scope="col" colspan="3">IP 서치</th>
				<th scope="col" colspan="3">충전내역(10만원/ 건)</th>
				<th scope="col" colspan="3">환전내역(20만원/ 건)</th>
			</tr>
			<tr>
				<td>베팅날짜</td>
				<td>베당률</td>
				<td>예상배당</td>
				<td>게임</td>
				<td>당첨금액</td>
				<td>접속날짜</td>
				<td>아이피</td>
				<td>타아이디접속</td>
				<td>충전일자</td>
				<td>충전금액</td>
				<td>누적충전금</td>
				<td>환전일자</td>
				<td>환전금액</td>
				<td>누적환전금</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<ul class="tablestyle_game">
						<li class="win">1</li>
						<li class="win">2</li>
						<li class="lose">3</li>
						<li>4</li>
						<li>4</li>
						<li>2</li>
						<li>1</li>
						<li>2</li>
						<li>4</li>
						<li>1</li>
					</ul>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th scope="col" colspan="5">총 베팅내역(10만원) / 총당첨금액(5만원)</th>
				<th scope="col" colspan="3">고객센터 등록 내역( 건)</th>
				<th scope="col" colspan="3">쪽지발송 내용( 건)</th>
				<th scope="col" colspan="3">보너스금액 지급내역(20만원/ 건)</th>
			</tr>
			<tr>
				<td>베팅날짜</td>
				<td>베당률</td>
				<td>예상배당</td>
				<td>게임</td>
				<td>당첨금액</td>
				<td>게시날짜</td>
				<td colspan="2">제목</td>
				<td>발송날짜</td>
				<td colspan="2">제목</td>
				<td>보너스종류</td>
				<td>지급날짜</td>
				<td>지급금액</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<ul class="tablestyle_game">
						<li class="win">1</li>
						<li class="win">2</li>
						<li class="lose">3</li>
						<li>4</li>
						<li>2</li>
						<li>1</li>
						<li>2</li>
						<li>4</li>
						<li>1</li>
						<li>1</li>
					</ul>
				</td>
				<td></td>
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td colspan="2"></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
		</table>		
	</div>