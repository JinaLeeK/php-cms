$(document).ready(function() {
	//ajax for sub category
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

		$("#preview").css("height", "90px");
		$("#preview img").css({
			width: $("#output").width()/2 + 'px',
			height: $("#output").height()/2+ 'px'
		});
		$(this).imgAreaSelect({
			aspectRatio: '16:9',
			onSelectChange: preview,
			onSelectEnd: function(image, selection) {
				$("input[name=x1]").val(selection.x1);
				$("input[name=x2]").val(selection.x2);
				$("input[name=y1]").val(selection.y1);
				$("input[name=y2]").val(selection.y2);
				$("input[name=w]").val(selection.width);
				$("input[name=h]").val(selection.height);
			}
			});
	})

	$("#upload").click(function() {
		$("input[name=thumb_width]").val($("#output").width());
		$("input[name=thumb_height]").val($("#output").height());
		$("#output").imgAreaSelect({
			hide: true
		});
		$("#output").parent("div").hide();
		$("#cancel").hide();
		$("#upload").hide();
	});

	$("#cancel").click(function() {
		$("#output").attr("src","").imgAreaSelect({
			hide: true
		});
		$("input[type=file]").val("");
		$("#preview").parent("div").hide();
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
			post_sub_category_id :{
				required: true
			},
			post_content : {
				required: true
			}
		},
		messages: {
			post_title: "Please enter the title",
			post_content: "Please enter the content",
			post_category_id: "Select the category",
			post_sub_category_id: "Select the sub category"
		}
	});
})

var loadFile = function(e) {
	if (event.target.files['0']) {
		var url = URL.createObjectURL(event.target.files['0'])
		$("#output").parent("div").show();
		$("#preview").parent("div").show();
		$("#output").attr("src", url);
		$("#preview img").attr("src", url);
		$("#upload").removeClass("hidden").show();
		$("#cancel").removeClass("hidden").show();
	} else {
		$("#output").attr("src","").hide();
	}
}

var preview = function(img, selection) {
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
}
