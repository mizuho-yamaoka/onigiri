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
