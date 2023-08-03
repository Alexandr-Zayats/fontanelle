<?php
  namespace Phppot;
  session_start();
  $_SESSION['subpage'] = true;
  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/../lib/ImageModel.php';
  $imageModel = new ImageModel();

  if(isset($_POST['update'])) {
    //$updatetTime = date( 'd-m-Y h:i:s A', time () );
    //echo "<script>alert('$uid $name $email $phone $size $info');</script>";
    // print "sp_userupdateprofile ($uid,'$street','$resident','$size','$info', $status)";
    $userModel->call('sp_userupdateprofile', "$uid,'$street','$resident','$size','$info', $status");
    //echo "<script>alert('Профайл участка успешно обновлен');</script>";
    header('location:' . destPage());
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>РУЧЕЕК (кассир)</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <script src="../includes/scripts.js"> </script>
    <script src="../includes/scripts-img.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       <?php include_once('includes/sidebar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                    <!-- Topbar Navbar -->
  <?php include_once('includes/topbar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
<?php 
  $query = $userModel->call('sp_userprofile', $uid);
  foreach ($query as $result) {
?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <h1 class="h3 mb-0 text-gray-800"><?php echo "Участок № ".$result['id'];?> </h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Default Card Example -->
                            <div class="card mb-4">
                              <div class="card-header">
                                 Дата регистрации: <?php echo $result['RegDate'];?>
                              </div>
                              <div class="card-body">
                              <form method="post">
                                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0"
                                  role="grid" aria-describedby="dataTable_info" style="width: 100%;">              
                                  <tr>
                                    <th style="width:20%">Адрес</th>
                                    <td style="text-align:left">
                                      <select id="street" name="street" class="btn btn-primary btn-user btn-block">
                                      <?php
                                        $sql = $userModel->call('sp_streetList');
                                        foreach ($sql as $street) {
                                          if ( $street['id'] == $result['streetId'] ) {
                                            echo "<option value=".$street['id']." selected>".$street['name']."</option>";
                                          } else {
                                            echo "<option value=".$street['id'].">".$street['name']."</option>";
                                          }
                                        }
                                      ?>
                                      </select>
                                    </td>                  
                                  </tr>
                                  <tr>
                                    <th>Размер участка (соток)</th>
                                    <td>
                                      <input type="number" min="0.0" max="100.00" step="0.01"
                                        class="form-control form-control-user" id="size"
                                        value="<?php echo $result['Size'];?>" name="size" required="true"
                                      >
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Владелец</th>
                                    <td style="text-align:left">
                                      <select id="resident" name="resident" class="btn btn-primary btn-user btn-block">
                                      <?php
                                        $owner = $result['residentId'];
                                        $sql =  $userModel->call('residents', 0);
                                        foreach ($sql as $resident) {
                                          $resId=$resident['id'];
                                          if ($resident['id'] == $owner) {
                                            echo "<option value=".$resident['id']." selected>".$resident['resName']." ( ".$resident['phone1']." )</option>";
                                          } else {
                                            echo "<option value=".$resident['id'].">".$resident['resName']." ( ".$resident['phone1']." )</option>";
                                          }
                                        }
                                      ?>
                                      </select>
                                    </td>
                                  </tr>
				                          <tr>
                                    <th>Дополнительная Информация</th>
                                    <td>
                                      <input type="text" class="form-control form-control-user" 
                                        id="info" value="<?php echo $result['Info'];?>" name="info">
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>Последние изменения </th>
                                    <td><?php echo $result['LastUpdationDate'];?></td>
                                  </tr>
                                  <tr>
                                    <th>Статус</th>
                                    <td>
                                      <select id="status" name="status" class="btn btn-primary btn-user btn-block">
                                        <option value=1 <?php if($result['type'] == 1) {echo "selected";}?>>Проживают постоянно</option>";
                                        <option value=2 <?php if($result['type'] == 2) {echo "selected";}?>>Дачники</option>";
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <button type="submit" name="update" class="btn btn-primary btn-user btn-block">
                                        Сохранить
                                      </button>
                                    </td>
                              </form>  
                                  </tr>
                                  <tr>
                                  <?php
                                  unset($_SESSION['imageUploadedId']);
                                  $_SESSION['iType'] = 'doc';
                                  $_SESSION['imageOwner'] = $uid;
                                  $result = $imageModel->getAllImages($_SESSION['imageOwner'], $_SESSION['iType']);
                                  if (! empty($result)) {
                                    echo "<td colspan=2><table><tr>";
                                    foreach ($result as $row) {?>
                                      <td>
                                      <a href=""
                                        onClick="myWindow('../<?php echo $row["image"]?>', '<?php echo $row["image"]?>', 600, 600); return false;">
                                        <img src="../<?php echo $row['image']?>" width="100" border="0"/>
                                      </a>
                                      <?php formSubmit('imageId', $row['id'], 'Удалить', $_SERVER['HTTP_ORIGIN'] .'/image_delete.php')?>
                                      </td>
                                  <?php
                                    }
                                    echo "</tr></table></td>";
                                  } ?>
                                  </tr>
                                  <tr>
                                    <td>
                                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#imageModal">
                                        <i class="btn btn-primary btn-user">Прикрепить документы</i>
                                      </a>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            </div>
<?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
     <?php include_once('includes/footer.php');?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Image Modal-->
    <?php include_once('../includes/image-modal.php')?>
    <!-- Logout Modal-->
     <?php include_once('../includes/logout-modal.php');?>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
</body>
</html>
