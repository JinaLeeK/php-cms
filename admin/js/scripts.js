$(document).ready(function(){

  // $('.image-container').click(function() {
  //   var user_input;
  //
  //   location.reload();
  //   return user_input = confirm("sure to delete?");
  // })
  $(".page-header #category_option").change(function() {
    var category_id = $(this).val();
    var target = $(this).data('target');

    $.ajax({
      url: '../resources/templates/back/posts_in_category.php',
      type: 'GET',
      data: 'cat_id='+category_id+'&sub_cat_id='+0+'&target='+target,
      success: function(res) {
        $('.admin-posts tbody').html(res);
      }
    });

    $.ajax({
      type: "GET",
      url: "../resources/sub_category.php",
      data: 'cat_id='+category_id,
      success: function(res) {
        var content = "<option value='0'>All</option>" + res;
        $("#sub_category_option").html(content);
      }
    })
  });

  $(".temp-btn").click(function() {
    $.ajax({
      url: '../resources/templates/back/posts_in_category.php',
      type: 'GET',
      data: 'temp',
      success: function(res) {
        $('.admin-posts tbody').html(res);
      }
    })
  })

  $(".page-header #sub_category_option").change(function() {
    var cat_id = $("#category_option").val();
    var sub_cat_id = $(this).val();
    var target = $(this).data('target');

    $.ajax({
      url: '../resources/templates/back/posts_in_category.php',
      type: 'GET',
      data: 'cat_id='+cat_id+"&sub_cat_id="+sub_cat_id+"&target="+target,
      success: function(res) {
        $('.admin-posts tbody').html(res);
      }
    })
  });


  $("#selectAllBoxes").click(function(e) {
    if (this.checked) {
      $('.checkBoxes').each(function() {
        this.checked = true;
      })
    } else {
      $('.checkBoxes').each(function() {
        this.checked = false;
      })
    }
  })
  $("input[name=slide_file]").change(function() {
    $(".submit-btn").hide();
    $("#preview_").hide();

    if ((file = this.files[0])) {
      if(file.size > 3*1024*1024) {
        alert("Files size should be less than 3M. This file size is "+(target.size/1024/1024).toFixed(1)+"M.");
        $("input[name=slide_file]").val('');
      } else {
        src = URL.createObjectURL(file);
        $("#thumbnail_").attr("src", src).parent("div").show();
        $("#preview_ img").attr("src", src);
      }
    } else {
      $("#thumbnail_").parent("div").hide();
      $("#thumbnail_").imgAreaSelect({
        hide: true
      })

    }
  });

  $("#thumbnail_").on("load", function() {
    $("#preview_").css("height", "75px");
    $("#preview img").css({
      width:$("#thumbnail_").width() + 'px',
      height: $("#thumbnail_").height() + 'px'
    });
    $(this).imgAreaSelect({
      x1:0, y1:0, x2:235, y2:75
    });
    $("input[name=thumb_width]").val($("#thumbnail_").width());
    $("input[name=thumb_height]").val($("#thumbnail_").height());
    $('input[name=x1]').val(0);
    $('input[name=y1]').val(0);
    $('input[name=x2]').val(206);
    $('input[name=y2]').val(131);
    $('input[name=w]').val(206);
    $('input[name=h]').val(131);

    $(this).imgAreaSelect({
      aspectRatio:'940:299',
      onSelectEnd: function(image, selection) {
        $('input[name=x1]').val(selection.x1);
        $('input[name=x2]').val(selection.x2);
        $('input[name=y1]').val(selection.y1);
        $('input[name=y2]').val(selection.y2);
        $('input[name=w]').val(selection.width);
        $('input[name=h]').val(selection.height);

        var image_width = $("#thumbnail_").width();
        var image_height = $("#thumbnail_").height();
        var scaleX = 235 / (selection.width || 1);
        var scaleY = 75 / (selection.height || 1);
        $("#preview_ > img").css({
          width: Math.round(scaleX * image_width) + 'px',
          height: Math.round(scaleY * image_height) + 'px',
          marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
          marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });
        $("#preview_").show();
        $("input[name=upload_image]").show();

      }
    })
  })

  $("input[name=file]").click(function() {
    $('.bg-success').html('');
  })

  $("input[name=slide_file]").click(function() {
    $('.bg-success').html('');
  })

  $("input[name=file]").change(function(e) {
    $(".submit-btn").hide();
    $("#preview").hide();
    $("#remove").hide();
    var file, img;
    if(e.target.files['0']) {
      var target = e.target.files['0'];
      var url = URL.createObjectURL(target);
      if(e.size > 3*1024*1024) {
        alert("Files size should be less than 3M. This file size is "+(target.size/1024/1024).toFixed(1)+"M.");
        $("input[type=file]").val('');
      } else {
        $("#thumbnail").attr("src", url).parent("#preview-zone").show();
        $("#preview img").attr("src", url);

      }
    } else {
      hidePhotoZone()
    }
  });

  $("#cancel").click(function() {
    $("input[name=file]").val("");
    hidePhotoZone();
  });

  $("#remove").click(function() {
    $("input[name=file]").val("");
    $("#preview").attr("src","").hide();
    $("#remove").hide();
    $(".submit-btn").hide();
  })

  $("#save").click(function() {
    hidePhotoZone();
    $(".upload-btn").show();
    $("#preview").show();
    $("#remove").show();
    $(".submit-btn").show();
  })

  $("#thumbnail").on("load", function() {
    $(".upload-btn").hide();
      $("#preview").css("height","131px");
      $("#preview img").css({
        width: $("#thumbnail").width()+'px',
        height: $("#thumbnail").height()+'px'
      });


      $(this).imgAreaSelect({
        x1:0, y1:0, x2:206, y2:131
      });
      $("input[name=thumb_width]").val($("#thumbnail").width());
      $("input[name=thumb_height]").val($("#thumbnail").height());
      $('input[name=x1]').val(0);
      $('input[name=y1]').val(0);
      $('input[name=x2]').val(206);
      $('input[name=y2]').val(131);
      $('input[name=w]').val(206);
      $('input[name=h]').val(131);

      $(this).imgAreaSelect({
        aspectRatio: '206:131',
        onSelectEnd: function(image, selection) {
          $("input[name=x1]").val(selection.x1);
          $("input[name=x2]").val(selection.x2);
          $("input[name=y1]").val(selection.y1);
          $("input[name=y2]").val(selection.y2);
          $("input[name=w]").val(selection.width);
          $("input[name=h]").val(selection.height);

          var image_width = $("#thumbnail").width();
          var image_height = $("#thumbnail").height();
          var scaleX = 206 / (selection.width || 1);
          var scaleY = 131 / (selection.height || 1);
          $("#preview > img").css({
            width: Math.round(scaleX * image_width) + 'px',
            height: Math.round(scaleY * image_height) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
          });
        }
      });
  })

  $(".img-container").click(function(e) {
    if($("#preview")) {
      $("#preview").remove();
    }
    $(".bg-success").html("");

    var imageForm = $(this).parents(".caption").prev("img");
    var imageSrc  = ($(imageForm).attr("src")).replace('new_','');
    $(".thumbnail").removeClass("selected");
    $(this).parents(".thumbnail").addClass("selected");
    $("#thumbnail").attr("src", imageSrc);
  });

  $("#add-category-form").validate({
    rules: {
      title: {
        required: true
      },
      file: {
        required: true
      }
    },
    message: {
      title: "This field should not be empty",
      file: "This field should not be empty"
    }
  })

});

var preview = function(img, selection) {
  var image_width = $("#thumbnail_").width();
  var image_height = $("#thumbnail_").height();
  var scaleX = 940 / (selection.width || 1);
  var scaleY = 299 / (selection.height || 1);
  $("#preview > img").css({
    width: Math.round(scaleX * image_width) + 'px',
    height: Math.round(scaleY * image_height) + 'px',
    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
  });
}


var hidePhotoZone = function() {
  $("#thumbnail").attr("src","").imgAreaSelect({
    hide:true
  });
  $("#preview-zone").hide();
}
