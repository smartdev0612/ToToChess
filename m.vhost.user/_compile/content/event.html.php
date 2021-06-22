<link rel="stylesheet" href="https://idangero.us/swiper/dist/css/swiper.min.css">
<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<div id="m_contents">
    <div class="m_title">
        <h2 class="ghdro_free">이벤트</h2>
    </div>
    <div class="mo_list">
        <?php
        if ( $TPL_list_1 ) {
            foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
                ?>
                <img src="<?php echo $TPL_V1['file']?>" style="width:100%;max-width:1200px;">
                <?php
            }
        } ?>
    </div>
</div>

