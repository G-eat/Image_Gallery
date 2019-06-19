<?php
include_once("../config/connect.php");

$mysql = "SELECT * FROM albums";
$query = $pdo->prepare($mysql);
$query->execute();

$albums = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Image gallery</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  </head>
  <body>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
      <div class="container mt-3">
        <h5 class="alert alert-success">You deleted album succesfully.</h5>
     </div>
    <?php } ?>

    <div class="container mt-5">
      <div class="row">

          <?php foreach ($albums as $album): ?>
            <div class="col-4 mt-3">
              <div class="card h-100" style="width: 20rem;">
                <form  action="../backend/delete.php" method="post">
                  <button type="submit" class="close" aria-label="Close">
                    <input type="hidden" name="delete" value="<?php echo $album['id'] ?>">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </form>
                <img src="../images/<?php echo $album['album_image'] ?>" class="card-img-top" alt="There is no album images.">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title"><?php echo $album['name'] ?></h5>
                  <hr>
                  <p class="card-text"><?php echo $album['description'] ?></p>
                  <hr>
                  <!-- Button trigger modal -->
                  <div class="btn-group  mt-auto">
                    <button type="button" data-id="<?php echo $album['name'] ?>" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1"  id='example'>
                      Add Photo
                    </button>
                    <button type="button" data-id="<?php echo $album['name'] ?>" class="btn btn-info" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#exampleModal2" id='example2'>
                      All photos
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>


          <!-- call modal to create albums -->
          <div class="col-4 mt-3">
            <div class="card h-100" style="width: 20rem;">
              <img src="https://banner2.kisspng.com/20180514/usq/kisspng-computer-icons-plus-sign-clip-art-5af97b2328bf59.1562244915262994271669.jpg" class="card-img-top" alt="...">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">Add Album</h5>
                <p class="card-text">Create new album.</p>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-block mt-auto" data-toggle="modal" data-target="#exampleModal">
                  Create
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-5"></div>


    <!-- Modal  create album-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Album</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../backend/albums.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleFormControlInput1">Album Name :</label>
                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="New album" required>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Album Description :</label>
                <input type="text" class="form-control" name="description" id="exampleFormControlInput2" placeholder="Description ..." required>
              </div>
              <div class="form-group">
                <label for="exampleFormControlFile1">Image</label>
                <input type="file" name="file[]" class="form-control-file" id="exampleFormControlFile1" value="" multiple='multiple' required>
                <!-- <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1" required> -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal add photo -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="albumName"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../backend/addImages.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="hidden" value="">
              <div class="form-group">
                <label for="exampleFormControlFile1">Add Photos To Album</label>
                <input type="file" name="file[]" class="form-control-file" id="exampleFormControlFile1" value="" multiple='multiple' required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- modal all photos -->
    <div class="modal fade bd-example-modal-lg" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="name"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"  id='reset'>
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="carouselExampleIndicators" class="carousel slide">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="../albumPhotos/AllPhotos.jpg" alt="First slide">
                </div>
                <!-- album photos -->
                <div id='allalbumphotos'>

                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
          <br><br>
        </div>
      </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).on("click", "#example", function () {
         let album = $(this).data('id');
         $("#albumName").text(album);
         $("input[type=hidden][name=hidden]").val(album);
      });
    </script>
    <script src="../javascript/image.js" charset="utf-8"></script>
  </body>
</html>
