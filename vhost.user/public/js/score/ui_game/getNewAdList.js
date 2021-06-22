var MinigameAdBanner = function() {

    this.getNewBanner = function() {
        $.get('/abc_banner', function(res) {
            //$("#minigame_ad_banner").empty();
            $("#minigame_ad_banner").css({ 'display': 'block' });

            /*if(!res || res.length === 0) {
                const link = document.createElement('a');
                link.target = '_blank';
                link.href = "http://ntry.com/adcenter/main.php";
                
                const image = document.createElement('img');
                image.src = '/public/img/adcenter/abc_banner_bidding.jpg';
        
                link.appendChild(image);
                $("#minigame_ad_banner").append(link);
            } else {
                const banners = res;
                const rand_num = Math.floor(Math.random() * 100) + 1;
        
                let index = getBannerIndex(rand_num, banners.length);
                if(!index) index = 0;
                const banner = banners[index];
                const link = document.createElement('a');
                link.target = '_blank';
                link.href = "http://ntry.com/user/home.php?mb_id=" + banner.mb_id +  "&ad_zone=minigame";
                
                const image = document.createElement('img');
                image.src = banner.src;
        
                link.appendChild(image);
                $("#minigame_ad_banner").append(link);
            }*/
        });
    };

    function getBannerIndex(rand_num, user_count) {
        let index = 0;
        if (user_count === 4) {
            if (rand_num < 50) {
                index = 0;
            } else if (rand_num >= 50 && rand_num < 75) {
                index = 1;
            } else if (rand_num >= 75 && rand_num < 90) {
                index = 2;
            } else if (rand_num >= 90) {
                index = 3;
            }
        } else if (user_count === 3) {
            if (rand_num < 60) {
                index = 0;
            } else if (rand_num >= 60 && rand_num < 85) {
                index = 1;
            } else if (rand_num >= 85) {
                index = 2;
            }
        } else if (user_count === 2) {
            if (rand_num < 65) {
                index = 0;
            } else {
                index = 1;
            }
        } else {
            return 0;
        }
        return index;
    };

    this.hide = function() {
        $("#minigame_ad_banner").hide();
    }
};