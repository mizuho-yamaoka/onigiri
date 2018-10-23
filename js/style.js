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
//トグルmy page
$(function(){
$("#uinfo .user_img").on("click", function() {
$('.edita').slideToggle(800);	
});});
$("#btn").click(function() {
    $('#frameWindow').dialog('open');
});
//トグルbbs join
$(function(){
$("#joinbt a").on("click", function() {
$('.emailsend').slideToggle(1000);	
});});
$("#btn").click(function() {
    $('#frameWindow').dialog('open');
});

//iframe
//modal
$(function(){
  //テキストリンクをクリックしたら
	$(".modal-open").click(function(){
	  //body内の最後に<div id="modal-bg"></div>を挿入
		$("body").append('<div id="modal-bg"></div>');
    
    //画面中央を計算する関数を実行
    modalResize();
    //モーダルウィンドウを表示
		$("#modal-bg,#modal-main").fadeIn("slow");
    //画面のどこかをクリックしたらモーダルを閉じる
		$("#modal-bg").click(function(){
			$("#modal-bg,#modal-main").fadeOut("slow",function(){
	      //挿入した<div id="modal-bg"></div>を削除
				$('#modal-bg').remove() ;
			});
	
		});
    
    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
		$(window).resize(modalResize);
		function modalResize(){
	
			var w = $(window).width();
			var h = $(window).height();
			
			var cw = $("#modal-main").outerWidth();
			var ch = $("#modal-main").outerHeight();
      
	    //取得した値をcssに追加する
			$("#modal-main").css({
              "left": ((w - cw)/2) + "px",
              "top": ((h - ch)/2) + "px"
          	});
		}
	});
});
//modal
$(function(){
  //テキストリンクをクリックしたら
	$(".modal-openco").click(function(){
	  //body内の最後に<div id="modal-bg"></div>を挿入
		$("body").append('<div id="modal-bgc"></div>');
    
    //画面中央を計算する関数を実行
    modalResize();
    //モーダルウィンドウを表示
		$("#modal-bgc,#modal-mainCo").fadeIn("slow");
    //画面のどこかをクリックしたらモーダルを閉じる
		$("#modal-bgc").click(function(){
			$("#modal-bgc,#modal-mainCo").fadeOut("slow",function(){
	      //挿入した<div id="modal-bgc"></div>を削除
				$('#modal-bgc').remove() ;
			});
	
		});
    
    //画面の左上からmodal-mainの横幅・高さを引き、その値を2で割ると画面中央の位置が計算できます
		$(window).resize(modalResize);
		function modalResize(){
	
			var w = $(window).width();
			var h = $(window).height();
			
			var cw = $("#modal-mainCo").outerWidth();
			var ch = $("#modal-mainCo").outerHeight();
      
	    //取得した値をcssに追加する
			$("#modal-mainCo").css({
              "left": ((w - cw)/2) + "px",
              "top": ((h - ch)/2) + "px"
          	});
		}
	});
});
