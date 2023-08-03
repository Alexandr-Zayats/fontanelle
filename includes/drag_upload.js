function upload_file(e) {
  e.preventDefault();
  ajax_file_upload(e.dataTransfer.files[0]);
}
   
function file_explorer() {
  document.getElementById('fileToUpload’).click();
  document.getElementById(‘selectfile’).onchange = function() {
    const files = document.querySelector(‘[type=file]’).files;
    for (i = 0; i < files.length; i++) {
      fileobj = document.getElementById('selectfile').files[i];
      ajax_file_upload(fileobj);
    }
  };
}
 
document.getElementById('fileToUpload').onchange = function() {
  ajax_file_upload(document.getElementById('fileToUpload').files[0]);
};
 
function ajax_file_upload(file_obj) {
  if(file_obj != undefined) {
    var form_data = new FormData();                  
    form_data.append('file', file_obj);
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../drag_image_upload.php", true);
    xhttp.onload = function(event) {
      oOutput = document.querySelector('.img-content');
      if (xhttp.status == 200 && this.responseText != "error") {
        oOutput.innerHTML = "<img src='"+ this.responseText +"' alt='Image' />";
      } else {
        oOutput.innerHTML = "Error occurred when trying to upload your file.";
      }
    }
    xhttp.send(form_data);
  }
}
