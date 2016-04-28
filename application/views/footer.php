	
		<div class="feedback-box hide">
			<h3>建议和反馈</h3>
			<form  method="post" name="keyWordSearch" action="<?php echo base_url().'index.php/manage/feedBack'?>">
				<label for="textFeedback">请填写你的建议和反馈</label>
				<textarea id="textFeedback" name="textFeedback"></textarea>
				<button id="feedbackBtn">确定</button>
				<button id="feedbackReset">取消</button>
			</form>
		</div>

	</div>
	<script type="text/javascript">
	$("a").click(function(event) {
		var a_id = $(this).attr("data-id");
		if ( !!a_id ) {
			$.ajax({
				url: base_url+'index.php/manage/updatePv',
				type: 'POST',
				dataType: 'text',
				data: {id: a_id},
				success: function(res){
					if ( res == 404 ) {
	                    window.location.assign(base_url);
					}
				},
				error: function(err){
					console.error( err );
				}
			})
		};
	});
	$("#feedbackButton").click(function(event) {
		event.preventDefault();
		$(".feedback-box").removeClass('hide');
	});
	$("#feedbackReset").click(function(event) {
		$(".feedback-box").addClass('hide');
	});
	</script>
	<style type="text/css">
	.feedback-box{ 
		width: 500px;height: 300px;
		position: absolute;background:#fff; 
		border: 1px solid #ddd;border-radius: 4px;
		margin-left: -250px;left:50%;top: 30px;
	}
	.feedback-box h3{ background: #EFF6FE;padding: 12px 8px; }
	.feedback-box label{
		font-size: 14px;
	    height: 30px;
	    display: block;
	    line-height: 30px;
	    padding-left: 10px;
	}
	.feedback-box textarea{
		width: 430px;
	    height: 153px;
	    margin-left: 25px;
	    border-radius: 4px;
	    padding: 8px;
	}
	.feedback-box button{ 
	    padding: 5px 10px;
	    background: #EFF6FE;
	    border: none;
	    cursor: pointer;
	    float: right;
	    margin-right: 25px;
    }
    #feedbackReset{ background: #fff; }
	</style>
</body>
</html>