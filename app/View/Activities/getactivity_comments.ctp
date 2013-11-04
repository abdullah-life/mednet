<script type="text/javascript">
    
    $(document).ready(function(){

        $("#addComment").live("click",function(){
            var comment         =   $(".comment_data").val();
            var activityid      =   $("#commentarea").attr('activityid');
            
            if(!$.trim(comment)){
                alert("Please enter a comment");
                return false;
            }
            $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"Activities/addnewComments/",
                cache: false, 
                type:'POST',
                 data: { comments: comment,id:activityid },
               	dataType:'html',
		success: function(data) { 
                        $("#allcomments").append(data);
                        $("#"+activityid).parent('td').first().html('<img src="<?php echo Router::url('/', true); ?>/img/comment2.png" class="comments  listingcomments" value="'+activityid+'">')
                        $(".comment_data").val("");
                    }
                })
                e.stopImmediatePropagation();
                e.preventDefault(); 
            })
         
        })
    
</script>
<div id="comment_box" style="color:red">
    <div id="allcomments">
    <?php
        foreach($activity['Activity']['comments'] as $comment){
    ?>
    <div class="comment" >
        <p><?php echo $comment['user_comment'];?></p>
        <span><?php echo $comment['user_name'];?></span>
    </div>		
    
    <?php 
        }
    ?>
    </div>
    <div id="commentarea" activityid="<?php echo $activity['Activity']['id']; ?>">
        Comment:<textarea class="comment_data" placeholder="Enter the comment here">
        
                </textarea>
        <input type="button" id="addComment" value="Submit">
    </div>
</div>
