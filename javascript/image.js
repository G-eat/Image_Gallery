$(document).ready(function(){

  $(document).on("click", "#example2", function () {
     let album = $(this).data('id');
     $("#name").text(album);
     $("input[type=hidden][name=hidden]").val(album);
     $("#carouselExampleIndicators").carousel(0);

  });

  $(document).on("click", "#example2", function () {
     $("#carouselExampleIndicators").carousel(0);
     let album_name = $(this).data('id');

     // album images slide
     $.ajax({
            url: "../backend/albumimages.php",
            method:'POST',
            data:{album_name:album_name},
            dataType:'JSON',
            success: function(result){
              result.forEach(function (image) {
                let img = $(`<img class="d-block w-100" id="${image.id}">`);
                img.attr('src', `../albumPhotos/${image.image_name}`);
                let div = $(`<div class="carousel-item"></div>`);
                img.appendTo(div);
                div.appendTo('#allalbumphotos');
                console.log(image.image_name);
              });
              console.log(result);
     }});
  });

  $(document).on("click", "#reset", function () {
    window.location = "../client/index.php";
  });

});
