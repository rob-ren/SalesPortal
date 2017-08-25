/**
 * Created by zhuo on 2017/5/26.
 */
function banner(){
    var href = window.location.href,
        protocol = "https:" || window.location.protocol, // 网站目前暂时无https
        vendorsHost = "",
        agencyHost = "";
    if (href.indexOf('www-t') === -1){
        vendorsHost = protocol + "//vendors.ipx.net";
        agencyHost = protocol + "//agency.ipx.net";
    } else {
        vendorsHost = protocol + "//vendors-t.ipx.net:9091";
        agencyHost = protocol + "//agency-t.ipx.net:9091";
    }

    var head = '<div class="wrap_center clearfix">\
        <a href="index.html" class="homelogo"><img src="img/homelogo.png" width="156"></a>\
        <ul class="nav_ul">\
        <li id="index"><a href="index.html">Home</a></li>\
        <li id="market"><a href="projects.html">IPX Market</a></li>\
        <li id="about"><a href="about.html">About IPX</a></li>\
        </ul>\
        <ul class="log_ul">\
        <li>Sign In <ol> \
        <li class="vendor_li"><a target="_blank" href="'+vendorsHost+'/#/?language=en_US"><i class="iconfont icon-projects2"></i>Sign in as Vendor</a></li>\
        <li class="agency_li"><a target="_blank" href="'+agencyHost+'/#/?language=en_US"><i class="iconfont icon-tie_light"></i>Sign in as Agency</a></li></ol></li>\
        <li> <div class="join_box">Join</div><ol>\
        <li class="vendor_li"><a target="_blank" href="'+vendorsHost+'/#/register?language=en_US"><i class="iconfont icon-projects2"></i>Join as Vendor</a></li>\
        <li class="agency_li"><a target="_blank" href="'+agencyHost+'/#/register?language=en_US"><i class="iconfont icon-tie_light"></i>Join as Agency</a></li>\
        </ol></li>\
        <li class="language_btn language_EN" ><span class="toCN" onClick="changeLanguage(1)">中</span> / <span class="toEN" onClick="changeLanguage(2)">En</span></li>\
        </ul>\
        <span class="nav_btn iconfont icon-viewlist"></span>\
        </div>\
        <div class="navBg"></div>';
    return head;
}

function foot(){

    var foot = '<div class="home_footer_bg">\
    <div class="wrap_center">\
      <div class="copyright">\
        <a href="#" class="foot_logo"><img src="img/homelogo.png"></a>\
        <p><strong>+86 400 800 7720 (CN)</strong>\
        <span>09:30 -18:00 (Mon-Fri)</span>\
        <strong>+61 3 9813 4595 (AU)</strong>\
        <span>09:00 -17:00 (Mon-Fri)</span>\
        </p>\
        <ul>\
        	<li><img src="images/weiQcode.png"><span>IPX WeChat</span></li>\
          <li><img src="images/linkQcode.png"><span>IPX LinkedIn</span></li>\
        </ul>\
      </div>\
      <div class="foot_address foot_address_AU">\
      	<h3>AUSTRALIA OFFICE</h3>\
        <dl>\
        	<dt>Melbourne</dt>\
          <dd><i class="iconfont icon-map"></i>Level 1,668 Burwood Road,Hawthorn East,VIC 3123</dd>\
          <dd><i class="iconfont icon-email"></i>office@ipx.net</dd>\
          <dd><i class="iconfont icon-tel"></i>+61 3 9813 4595</dd>\
        </dl>\
        <dl>\
        	<dt>Sydney</dt>\
          <dd><i class="iconfont icon-map"></i>108,Pacific Trade Centre,368 Sussex St, Sydney NSW 2000</dd>\
          <dd><i class="iconfont icon-email"></i>nsw@au.ipx.net</dd>\
          <dd><i class="iconfont icon-tel"></i>+61 2 9267 3888</dd>\
        </dl>\
      </div>\
      <div class="foot_address foot_address_CN">\
      	<h3>CHINA OFFICE</h3>\
        <dl>\
        	<dt>Changsha</dt>\
          <dd><i class="iconfont icon-map"></i>Level 16, West Tower, HuNan Chamber of Commerce Building, 569 FuRong Zhong Road, Changsha </dd>\
          <dd><i class="iconfont icon-email"></i>changsha@cn.ipx.net</dd>\
          <dd><i class="iconfont icon-tel"></i>+86 731 8447 7440</dd>\
        </dl>\
        <dl>\
        	<dt>Beijing</dt>\
          <dd><i class="iconfont icon-map"></i>Level 22, ShangDu International Centre,8 DongDaQiao Road A,ChaoYang District, Beijing 100020</dd>\
          <dd><i class="iconfont icon-email"></i>beijing@cn.ipx.net</dd>\
          <dd><i class="iconfont icon-tel"></i>+86 010 5870 0428</dd>\
        </dl>\
        <dl>\
        	<dt>Shanghai</dt>\
          <dd><i class="iconfont icon-map"></i>Suite 1510, Smick Plaza, 1090 Century Road, PuDongXin District, Shanghai 200120</dd>\
          <dd><i class="iconfont icon-email"></i>shanghai@cn.ipx.net</dd>\
          <dd><i class="iconfont icon-tel"></i>+86 21 6172 2092</dd>\
        </dl>\
      </div>\
      <ul class="foot_nav">\
      	<li id="footIndex"><a href="index.html">Home</a></li>\
        <li id="footProjects"><a href="projects.html">IPX Market</a></li>\
        <li id="footAbout"><a href="about.html">About IPX</a></li>\
        <li id="footOffices"><a href="map.html">IPX Global Offices</a></li>\
        <li id="footFAQ"><a href="question.html">FAQ</a></li>\
        <li id="footDisclaimer"><a href="Terms.html">Disclaimer</a></li>\
        <li id="footPrivacy"><a href="policy.html">Privacy Policy</a></li>\
      </ul>\
      <div class="clearfix"></div>\
      <p class="copyright_txt">International Property Exchange Centre Pty Ltd    Copyright © 2012-2017 IPX.net All rights reserved.</p>\
    </div>\
  </div>\
</div> ';

    return foot;
}



function changeLanguage(lang){
    var url=location.href;
    if(lang==2){
        url=url.replace('cn/','en/');
    }
    else{
        url=url.replace('en/','cn/');
    }
    location.href=url;
}

function askTool(){
    var tool='  <a target="_blank" href="http://lzt.zoosnet.net/LR/Chatpre.aspx?id=LZT80944766&lng=en"><i class="iconfont icon-ask"></i><b>Enquire</b></a>\
    <a  class="hotline_Tool"><i class="iconfont icon-tel"></i><b>Hotline</b><span class="float_tel"><strong>+86 400 800 7720 (CN)</strong><em>09:30-18:00 (Mon-Fri)</em><strong>+61 3 9813 4595 (AU)</strong><em>09:00-17:00 (Mon-Fri)</em></span></a>\
        <a  href="question.html"><i class="iconfont icon-wenhao"></i><b>FAQ</b></a>';
    return tool;
}

function mobileHead(){
    var head='<div class="mobiel_menu_box_head">\
        <div  class="ipxLogo">\
         <a href="index.html">\
                <span class="square1 ipxgreen_bg"></span>\
                <span class="square2 white_bg"></span>\
                <span class="square3 white_bg"></span>\
                <span class="square4 ipxgreen_bg"></span>\
                <span class="square5 white_bg"></span>\
                <span class="square6 white_bg"></span>\
                <span class="square7 ipxgreen_bg"></span>\
                <span class="square8 white_bg"></span>\
                <span class="square9 white_bg"></span>\
                <span class="square10 ipxgreen_bg"></span>\
                <span class="square11 white_bg"></span>\
                <span class="square12 ipxgreen_bg"></span>\
            </a>\
        </div>\
        <a class="colse_mobiel_menu iconfont icon-cross" href="javascript:;"></a>\
        </div>\
        <ul class="mobiel_menu_box_list">\
        <li><a  href="projects.html">IPX Market</a></li>\
        <li><a  href="about.html">About IPX</a></li>\
        <li><a  href="map.html">IPX Global Offices</a></li>\
        <li><a  href="question.html">FAQ</a></li>\
        <li><a  href="Terms.html">Disclaimer</a></li>\
        <li><a  href="policy.html">Privacy Policy</a></li>\
        <li><a >Register</a>\
        <ul>\
        <li><a target="_blank" href="https://vendors.ipx.net/#/register?language=en_US" class="ipx_btn ipx_bluebd_btn ipx_L_btn ">Vendor</a></li>\
        <li><a target="_blank" href="https://agency.ipx.net/#/register?language=en_US" class="ipx_btn ipx_greenbd_btn ipx_L_btn ">Agency</a></li>\
        </ul>\
        </li>\
        <li><a >语言</a>\
        <ul>\
        <li><a href="javascript:changeLanguage(1)" class="ipx_btn ipx_bluebd_btn ipx_L_btn">中文</a></li>\
        <li><a href="javascript:changeLanguage(2)" class="ipx_btn ipx_greenbd_btn ipx_L_btn">English</a></li>\
        </ul>\
        </li>\
        </ul>';
    return head;
}
function changeActive(){
    var url=location.href;
    if(url.indexOf('index') > -1){
        $('#index').attr("class","active ");
        $('#footIndex').attr("class","active ");
    }else if(url.indexOf('projects') > -1){
        $('#market').attr("class","active ");
        $('#footProjects').attr("class","active ");
    }else if(url.indexOf('about') > -1){
        $('#about').attr("class","active ");
        $('#footAbout').attr("class","active ");
    }else if(url.indexOf('map') > -1){
        $('#footOffices').attr("class","active ");
    }else if(url.indexOf('question') > -1){
        $('#footFAQ').attr("class","active ");
    }else if(url.indexOf('policy') > -1){
        $('#footPrivacy').attr("class","active ");
    }else if(url.indexOf('Terms') > -1){
        $('#footDisclaimer').attr("class","active ");
    }
    
}

function formatDate(now) { 
    now = new Date(now);
    var year=now.getFullYear(); 
    var month=now.getMonth()+1; 
    var date=now.getDate(); 
    // var hour=now.getHours(); 
    // var minute=now.getMinutes(); 
    // var second=now.getSeconds(); 
    return year+"/"+month+"/"+date; 
} 
function projectName(type){
    switch (type) {
        case 1:
            return 'Apartment'
            break;
        case 2:
            return 'House'
            break;
        case 3:
            return 'Townhouse'
            break;
        case 4:
            return 'Land'
            break;
                
        default:
            break;
    }
}


function fmoney(num) {
    var num = (num || 0).toString(), result = '';
    while (num.length > 3) {
        result = ',' + num.slice(-3) + result;
        num = num.slice(0, num.length - 3);
    }
    if (num) { result = num + result; }
    return result;
}

(function urlApi(){
    var  windowOrigin = window.location.href;
    var  hostConfig = {
        pro: {
            origin: 'https://vendors.ipx.net'
        },
        test: {
            // origin: 'http://172.23.1.15:8081' // 周超
            // origin: 'http://172.23.1.14:8080' // 陈远长
            // origin: 'http://localhost:8081' // 本地服务器
            // origin: 'http://localhost:8080' // 本地服务器
            // origin: 'http://vendors-dev.ipx.net' // 开发服务器
             origin: 'https://vendors-t.ipx.net:9091' // 测试服务器
            // origin: 'https://vendors.ipx.net' // 生产服务器
        }
    };

    var  localOrigin = windowOrigin.substr(0, 10);

    env = {
        config: (localOrigin === 'http://loc' || localOrigin === 'http://172' || localOrigin ==='file:///E:'|| localOrigin ==='https://ww') ? hostConfig.test : hostConfig.pro
    };
})();

$(document).ready(function(){
    // urlApi()
    
    document.getElementById("head").innerHTML=banner();
    document.getElementById("foot").innerHTML=foot();
    document.getElementById("toolcontainer").innerHTML=askTool();
    document.getElementById("mobilehead").innerHTML=mobileHead();

    changeActive()

	//顶部条固定效果
	function autoScrollbar() {
		var scrlTop = $(document).scrollTop(); //获取屏幕顶部距文档顶部的距离
		var navH=81-scrlTop/10;
		var Myopacity=scrlTop*2/100;
		if (scrlTop<200) {
			$(".Navi").css("height",navH+"px")
			$(".navBg").css("opacity",Myopacity)
			$(".homelogo").css("width","156px")
			$(".nav_ul").css("left","190px")
		}else{
            $(".Navi").css("height","61px")
            $(".homelogo").css("width","40px")
            $(".navBg").css("opacity",1)
			$(".nav_ul").css("left","74px")
		}
	}
	// autoScrollbar();
	window.onscroll = function () {
		autoScrollbar();
	}
	//导航条线条效果
	$('.nav_ul').moveline({
		color:"#0ccbdb",
	});
	//注册登录下拉效果
	$(".log_ul li").hover(function(){
    $(this).children("ol").slideDown(300)
	},function(){
		$(this).children("ol").stop(true,true).fadeOut(200)
	})
	//banner切换效果
	$(".header_btn li").hover(function(){
		$(".header_btn li").removeClass("active")
		$(this).addClass("active")
		if($(".vendors_btn").hasClass("active")){
			$(".bannerbg2").stop(true,true).animate({"opacity":"1"},200)
			$(".bannerbg1").stop(true,true).animate({"opacity":"0"},200)
		}
		if($(".agency_btn").hasClass("active")){
			$(".bannerbg1").stop(true,true).animate({"opacity":"1"},200)
			$(".bannerbg2").stop(true,true).animate({"opacity":"0"},200)
		}
    })
    
        //移动端头部导航效果

    $(".nav_btn").click(function(){
			$(".mobiel_menu_box").show();	
			$(".ipx_home_body").css({"overflow":"hidden","position":"fixed","width":"100%","height":"100%"})	
			$(".ipx_banner").addClass("blurStyle")
		})
    // 移动端登陆，弹出提示, 4s后自动关闭
    $('#mobilehead .agency_agent_login_box').on('click', '.ipx_L_btn', function(){
        $('#IPXToast').show();
    });

    // Toast关闭
    $('#IPXToast').on('click', '.ipx_close_confirm', function(){
        $('#IPXToast').hide();
    });

    $(".mobiel_menu").click(function(){
        $(".mobiel_menu_box").show();
        $(".ipx_home_body").css({"overflow":"hidden","position":"fixed","width":"100%","height":"100%"})
        $(".ipx_banner").addClass("blurStyle")
    });
    $(".colse_mobiel_menu").click(function(){
        $(".mobiel_menu_box").hide();
        $(".ipx_banner").removeClass("blurStyle")
        $(".ipx_home_body").removeAttr("style")
    });
    $(".mobiel_menu_box_list>li>a").click(function(){
        $(".mobiel_menu_box_list>li>ul").slideUp(200);
        $(this).next("ul").slideDown(300);
    });
});

// 处理推荐到首页图片问题
window.indexImageLoad = function(e){
    var selfWidth = e.width,
        selfHeight = 2 * selfWidth / 3;
    e.height = selfHeight;
};