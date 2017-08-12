<form method="POST" id="register_form">
<input type="text" name="username" id="username" placeholder="User Name" required="">
<input type="text" name="mobile" id="mobile" placeholder="Mobile" required="">
<input type="text" name="email" id="email" placeholder="Email" required="">
<input type="text" name="password" id="password" placeholder="Password" required="">
<input type="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required="">
<button type="submit">Submit</button>
</form>
<script type="text/javascript">
	var register_form=$("#register_form");
	register_form.submit(function(e){
		e.preventDefault();
		$.ajax({
			url:base_url("api/register"),
			method:"POST",
			data:register_form.serializeArray(),
			dataType:"JSON",
			beforeSend:function(){
				$(".response").html("progress");
			},
			success:function(data){
				$(".response").html(data["email"]);
			},
			error:function(){
				$(".response").html("failed");
			}
		});
	})
</script>