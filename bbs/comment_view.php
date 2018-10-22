<div class="collapse" id="collapseComment<?php echo $feed["id"] ?>">
    <div class="con_1">
        <?php foreach ($feed['comments'] as $comment): ?>
            <div class="comments">
            <img src="../user_profile_img/<?php echo $comment['img_name']?>" width="40" class="img-circle">
				<dl>
				<dt><a href="bbs_people.php?id=<?php echo $feed['user_id']?>"><?php echo $comment['name']?></a></dt>
                <dd><?php echo $comment['comments'] ?></dd>
				</dl>
            </div>
        <?php endforeach; ?>
        <form method="post" class="bbsComment" action="comment.php" role="comment">
            <div>
                <img src="../user_profile_img/<?php echo $user['img_name']; ?>" width="40" class="img-circle">
            </div>
            <div class="form-group">
                <input type="text" name="write_comment" class="form-control" style="width:400px;border-radius: 100px!important; -webkit-appearance:none;" placeholder="コメントを書く">
            </div>
            <div>
                <?php if(isset($_SESSION['empty_comment'])): ?>
                  <p>コメントを記入してください</p>
                <?php endif; ?>
            </div>
            <input type="hidden" name="feed_id" value="<?php echo $feed["id"] ?>">
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary">コメントする</button>
            </div>
        </form>
    </div>
</div>