<?php
echo '<pre>';
var_dump($feed['email']);
echo '</pre>';
?>
<div class="collapse" id="collapseComment<?php echo $feed["id"] ?>">
    <form action="" method="GET">
        <p>投稿者にあなたのメールアドレスを送信します</p>
        <input type="emai" name="joiner_email" placeholder="your e-mail adress" >
        <input type="submit" name="sumbit" value="SEND">
        
    </form>
</div>