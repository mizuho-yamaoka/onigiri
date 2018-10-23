
<div class="collapse" id="collapseComment<?php echo $feed["id"] ?>">
    <form action="email.php" method="GET">
        <p>メールアドレス送信後投稿者からの連絡をお待ちください：）<br>
        Plese wait a while to get reply from the host.</p>
        <input type="emai" name="joiner_email" placeholder="your e-mail adress" >
        <input type="hidden" name="poster_email" value="<?php echo $feed['email'] ?>">
        <input type="hidden" name="feed_id" value="<?php echo $feed_id?>">
        <input type="submit" name="sumbit" value="SEND">

        
    </form>
</div>