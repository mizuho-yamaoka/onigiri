<div class="collapse" id="collapseComment<?php echo $feed["id"] ?>">
    <div class="con_1">
        <?php foreach ($feed['comments'] as $comment): ?>
            <div class="comments">
            <img src="../user_profile_img/<?php echo $comment['img_name']?>" class="img-circle">
				<dl>
				<dt><a href="bbs_people.php?id=<?php echo $feed['user_id']?>"><?php echo $comment['name']?></a></dt>
                <dd><?php echo $comment['comments'] ?></dd>
				</dl>
            </div>
        <?php endforeach; ?>
        <form method="post" class="bbsComment" action="comment.php" role="comment">
            <div>
                <img src="../user_profile_img/<?php echo $user['img_name']; ?>" class="img-circle">
            </div>
            <div class="form-group">
                <input type="text" name="write_comment" class="form-control" placeholder="コメントを書く">
                <?php if(isset($_SESSION['empty_comment'])): ?>
                  <p>コメントを記入してください</p>
                <?php endif; ?>
            <input type="hidden" name="feed_id" value="<?php echo $feed["id"] ?>">
                <button type="submit" class="btn"><span style="font-size: 3rem;margin-left: 10px;
    color: #2d93d6;"><i class="fas fa-comments"></i></span></button>
            </div>
        </form>
    </div>
</div>