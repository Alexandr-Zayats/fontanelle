<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Image Modal-->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Добавить фото:</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <form class="user" name="image" id="image" method="post" enctype="multipart/form-data"
                    action="<?php echo $_SERVER['HTTP_ORIGIN'] .'/image_upload.php'?>">
                  <div class="modal-body">
                    <input type="file" name="fileToUpload[]" id="fileUpload"
                      multiple="multiple" accept=".jpg, .jpeg, .png, .gif">
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload" class="btn btn-primary">
                      Добавить
                    </button>
                  </div>
                </form> 
            </div>
        </div>
    </div>
