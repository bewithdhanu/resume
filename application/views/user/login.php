<form method="POST" id="login_form">
<input type="text" name="email" id="email" placeholder="Email" required="">
<input type="password" name="password" id="password" placeholder="Password" required="">
<button type="submit">Submit</button>
<div class="response"></div>
</form>
<script type="text/javascript">
	var login_form=$("#login_form");
	login_form.submit(function(e){
		e.preventDefault();
		$.ajax({
			url:base_url("api/login"),
			method:"POST",
			data:login_form.serializeArray(),
			dataType:"JSON",
			beforeSend:function(){
				$(".response").html("progress");
			},
			success:function(data){
				$(".response").html(data["data"]["email"]);
			},
			error:function(){
				$(".response").html(data["data"]);
			}
		});
	})
</script>