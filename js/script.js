$(document).ready(function() {
	// comment edit
	$(document).on("click", ".comment_login", function() {
		$('.modify-comment').hide();
		$('.modify-del').show();
		$('.comments p').show();

		var comment_id = $(this).data('id');
		var role = $(this).data('role');

		$("#comment-msg").html('');
		$(".modal-body #comment_id").val(comment_id);
		$(".modal-body #role").val(role);
	})

	$(".modifyCommentToggle").click(function() {
			var this_ = $(this).parents(".modify-comment").hide();
			$(this_).prev().show().prev().show();
	});

	if ($(this).find('#add-post-form').length > 0) {
		var cat_id = $("#category_option").val();
		$.ajax({
			type: "GET",
			url: "resources/sub_category.php",
			data: "cat_id="+cat_id,
			success:function(res) {
				$("#sub_category_option").html(res);
			}
		})
	}


  // edit photo when adding posts
	$("#output").on("load", function() {
		$("#preview").css("height", "90px");
		$("#preview img").css({
			width: $("#output").width()/2 + 'px',
			height: $("#output").height()/2 + 'px'
		});
		$("#preview").show();
		$(".upload-btn").show();

		$(this).imgAreaSelect({
			x1:0, y1:0, x2:320, y2:180
		})
		$("input[name=thumb_width]").val($("#output").width());
		$("input[name=thumb_height]").val($("#output").height());
		$('input[name=x1]').val(0);
		$('input[name=y1]').val(0);
		$('input[name=x2]').val(320);
		$('input[name=y2]').val(180);
		$('input[name=w]').val(320);
		$('input[name=h]').val(180);
		$("#photo-zone").show();

		$(this).imgAreaSelect({
			aspectRatio: '16:9',
			onSelectEnd: function(image, selection) {
				$("input[name=x1]").val(selection.x1);
				$("input[name=x2]").val(selection.x2);
				$("input[name=y1]").val(selection.y1);
				$("input[name=y2]").val(selection.y2);
				$("input[name=w]").val(selection.width);
				$("input[name=h]").val(selection.height);

				var image_width = $("#output").width();
				var image_height = $("#output").height();
				var scaleX = 160 / (selection.width || 1);
				var scaleY = 90 / (selection.height || 1);
				$("#preview > img").css({
					width: Math.round(scaleX * image_width) + 'px',
					height: Math.round(scaleY * image_height) + 'px',
					marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
					marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
				});
				$("#preview").show();
				$(".upload-btn").show();
			}
		});
	});

	$(".cancel-btn").click(function() {
		$("input[name=deleteImg]").val(true);
		$("input[type=file]").val("");
		$("#preview").hide();
		$(this).hide();
	})

	$(".upload-btn").click(function() {
		$(this).hide();
		$("#output").parent("div").hide();
		$("#output").imgAreaSelect({
			hide: true
		});
		$(".cancel-btn").show();
	})

	$("#post-status").change(function() {
		if ($(this).val() == 0 ) {
			window.location.assign("/kids01/posts.php?mypost");
		} else {
			window.location.assign("/kids01/posts.php?mypost&status="+$(this).val());
		}
	})


	$("#category_option").change(function() {
		var cat_id = $(this).val();
		$.ajax({
			type: "GET",
			url: "resources/sub_category.php",
			data: 'cat_id='+cat_id,
			success: function(res) {
				$("#sub_category_option").html(res);
			}
		})
	});

	// validation for user validation
	$("#register-form").validate({
		rules:
		 {
			 password: {
					required: true
			 },
			 username: {
			  	required: true
				},
			 email : {
				  required: true
			 },
			 password2 : {
				 required: true,
				 equalTo : "#key"
			 }

			},
		messages:
			{
				password:"Please enter your password",
  			username : "please enter your username",
				password2: "Password should be identical",
				email : "Please enter your email"
		 }
	})

	$("#login-form").validate({
		rules:
		 {
			 password: {
					required: true
			 },
			 username: {
					required: true
				}
			},
		messages:
			{
				password:"Please enter your password",
				username : "please enter your username",
		 }
	})

	$("#add-post-form").validate({
		rules:
		{
			post_title: {
				required: true
			},
			post_category_id : {
				required: true
			},
			// post_sub_category_id :{
			// 	required: true
			// },
			post_content : {
				required: true
			}
		},
		messages: {
			post_title: "Please enter the title",
			post_content: "Please enter the content",
			post_category_id: "Select the category",
			// post_sub_category_id: "Select the sub category"
		}
	});

	$("#comment-login-form").validate({
		rules: {
			username: {
				required: true
			},
			password: {
				required: true
			}
		},
		messages: {
			username: "Please enter the name",
			password: "Please enter the password"
		},
		submitHandler: submitForm
	})
})

function submitForm() {
	var data = $("#comment-login-form").serialize();

	$.ajax({
		type: 'POST',
		url: 'resources/comment_login.php',
		data: data,
		dataType: 'json',
		success: function(res) {
			if(res['msg'] == 'ok') {
				if(res['role'] == 'modify'){
					var id = res['comment_id'];
					$("#modifyCommentForm" + id).show().prev().hide().prev().hide();
					$("#editModal").modal('hide');
				}
				if(res['role'] == 'delete' || res['role']=='review') {
					window.location.reload();
				}

		} else {
				$("#comment-msg").html("Invalid username and password");
			}
		}
	})
}

var loadFile = function(e) {
	$(".cancel-btn").hide();
	$(".upload-btn").hide();
	$("#preview").hide();

	if (event.target.files['0']) {
		var target = event.target.files['0'];
		if (target.size > 3*1024*1024) {
			alert("Files size should be less than 3M. This file size is "+(target.size/1024/1024).toFixed(1)+"M.");
			$("input[type=file]").val('');
		} else {
			url = URL.createObjectURL(target);
			$("#output").attr("src",url).parent("div").show();
			$("#preview img").attr("src", url);
		}
	} else {
		$("#output").parent("div").hide();
		$("#output").imgAreaSelect({
			hide: true
		})
	}
}
