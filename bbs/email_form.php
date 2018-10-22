
<div class="collapse" id="collapseComment<?php echo $feed["id"] ?>">
    <form action="email.php" method="GET">
        <p>投稿者にあなたのメールアドレスを送信します</p>
        <input type="emai" name="joiner_email" placeholder="your e-mail adress" >
        <input type="hidden" name="poster_email" value="<?php echo $feed['email'] ?>">
        <input type="submit" name="sumbit" value="SEND">
        <?php if (isset($_SESSION['email'])): ?>
          <p>送信完了（SENT）</p>
        <?php endif; ?>

        
    </form>
</div>