// JavaScript Document
//slick js
$(document).on('ready', function () {
	$(".regular").slick({
		dots: false,
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 1,
		prevArrow: '<img src="img/prev.png" class="slide-arrow prev-arrow">',
		nextArrow: '<img src="img/next.png" class="slide-arrow next-arrow">',
		responsive: [{
			breakpoint: 751,
			settings: {
				slidesToShow: 1
			}
		}]
	});
});

//ハンバーガーボタン
$(function () {
	$('.menu-trigger').on('click', function () {
		$(this).toggleClass('active');
		$("#overlay").fadeToggle();
		return false;
	});
});
//スムーススクロール
$(function(){
$('a[href^="#"]').click(function(){
var speed = 500;
var href= $(this).attr("href");
var target = $(href == "#" || href == "" ? 'html' : href);
var position = target.offset().top;
$("html, body").animate({scrollTop:position}, speed, "swing");
return false;
});
});
//トグル
$(function(){
$("#uinfo .user_img").on("click", function() {
$('.edita').slideToggle(800);	
});});
$("#btn").click(function() {
    $('#frameWindow').dialog('open');
});


//iframe
$(function(){
	var mdwBtn = $('.modalBtn'),
	overlayOpacity = 0.7,
	fadeTime = 500;

	mdwBtn.on('click',function(e){
		e.preventDefault();

		var setMdw = $(this),
		setHref = setMdw.attr('href'),
		wdHeight = $(window).height();
		$('body').append('<div id="mdOverlay"></div><div id="mdWindow"><div class="mdClose"></div><iframe id="contWrap"></iframe></div>');

		$('#contWrap').attr('src',setHref);
		$('#mdOverlay,#mdWindow').css({display:'block',opacity:'0'});
		$('#mdOverlay').css({height:wdHeight}).stop().animate({opacity:overlayOpacity},fadeTime);
		$('#mdWindow').stop().animate({opacity:'1'},fadeTime);

		$(window).on('resize',function(){
			var adjHeight = $(window).height();
			$('#mdOverlay').css({height:adjHeight});
		});

		$('#mdOverlay,.mdClose').on('click',function(){
			$('#mdWindow,#mdOverlay').stop().animate({opacity:'0'},fadeTime,function(){
				$('#mdOverlay,#mdWindow').remove();
			});
		});
	});
});