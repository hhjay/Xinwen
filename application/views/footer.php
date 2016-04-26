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
	</script>
</body>
</html>