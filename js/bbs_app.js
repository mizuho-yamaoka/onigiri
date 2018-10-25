// $ =jQuery
// $(要素)HTML要素の取得
// .on (トリガー,処理);
    $(document).on('click', '.js-like', function() {
    // どの投稿に関してか
    var feed_id = $(this).siblings('.feed-id').text();
    // 誰がいいねしたか
    var user_id = $(this).siblings('.user-id').text();

    var like_btn = $(this);
    var like_count = $(this).siblings('.like-count').text();
    console.log('FeedID:' + feed_id);
    console.log('UserID' + user_id);
    $.ajax({
    // 送信先、送信するデータを記述
    url: 'bbs_like.php',  //送信先
    type: 'POST',  //送信メゾット
    datatype: 'json',  //データのタイプ　
    data: {            //送信するデータ
        'feed_id':feed_id,
        'user_id':user_id,
    }
    })
    .done(function(data) {
    // 処理が成功したときのデータを記述
    // dataにはINSERT文の結果が入っている（成功したらtrue）
    console.log(data);
    if(data == 'true'){
        like_count++;
        like_btn.siblings('.like-count').text(like_count);
        like_btn.removeClass('js-like');
        like_btn.addClass('js-unlike');
        like_btn.children('span').html('<i class="far fa-thumbs-up"></i>');
    }
    })
    .fail(function(error) {
        console.log(error);
    // 処理が失敗したときの処理を記述
    })
});
// いいねを取り消す処理
// js-unlikeがクリックされたときに発動する発動

    $(document).on('click', '.js-unlike', function() {
    // 必要な値を取り出す
    // どの投稿に関してか
    var feed_id = $(this).siblings('.feed-id').text();
    // 誰がいいねしたか
    var user_id = $(this).siblings('.user-id').text();
    // 
    var like_btn = $(this)
    // 
    var like_count = $(this).siblings('.like-count').text();
    // 非同期処理
    $.ajax({
    // 送信先、送信するデータを記述
    url: 'bbs_like.php',  //送信先
    type: 'POST',  //送信メゾット
    datatype: 'json',  //データのタイプ　
    data:{            //送信するデータ
        'feed_id':feed_id,
        'user_id':user_id,
        'is_unlike': true
        }
    })
    .done(function(data) {
        console.log('取り消すのDONEメゾット')
    // 処理が成功したときのデータを記述
    // dataにはINSERT文の結果が入っている（成功したらtrue）
    if(data == 'true'){
        like_count--;
        like_btn.siblings('.like-count').text(like_count);
        like_btn.removeClass('js-unlike');
        like_btn.addClass('js-like');
        like_btn.children('span').html('<i class="fas fa-thumbs-up"></i>');
    }
    })
    .fail(function(error) {
    // 処理が失敗したときの処理を記述
    })
});

// $('#submit').click(function(e) {
//     console.log('hoge');
//     e.preventDefault();
//     var info = $('#foo').val();
//     info = info.replace(/\n/g, "<br />");
//     $.ajax({
//         type: "POST",
//         url: 'feed.php',
//         data: {foo: info}
//     });
//     // .done(function(data)){
//     //     console.log('data');
//     // }
// });

// $("textarea").change( function() {
//     var txtVal = $(this).val();
//     txtVal = txtVal.replace(/\r\n/g, "&lt;br /&gt;<br />");
//     txtVal = txtVal.replace(/(\n|\r)/g, "&lt;br /&gt;<br />");
//     $('#testpre').html('<p>'+ txtVal +'</p>');
// });
