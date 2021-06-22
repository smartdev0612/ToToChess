<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>DB추출</b></h5>
	</div>

	<h3>DB추출</h3>

	<p id="wrap_excel">회원 DB 내역을 CSV 격식으로 수출할 수 있습니다. 화일 이름은 당시 날짜시간으로 지정됩니다.</p>
	<div id="wrap_btn">
		<input type="button" name="open" value="회원 정보" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="location.href='/config/export_DBProcess?_TYPE=0'"/>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="open" value="배팅 정보" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="location.href='/config/export_NewBettingList'"/>
	</div>
	</form>

</div>