<?php
//db Connection file
include('../includes/config.php');
//code for createuser
  $id=150;
  $name="test";
  $username="test";
  $email="alexandr@zayats.org";
  $password="dfdsfsf";
  $isactive=1;
  //checking acccount if already exists
  $ret=mysqli_query($con,"call sp_getLastCounterValues(2)");
  //if($ret=mysqli_query($con, "call sp_checkidavailabilty(`$id`)")) {
  $result=mysqli_fetch_assoc($ret);
  print_r ($result);

/*
  $result=mysqli_num_rows($ret);
    echo "<script>alert('Участок уже заерегистрирован!');</script>";
  } else {
    // $ret->close();
    mysqli_close($con);
    // $con->next_result();
    // echo "<script>alert('Before query');</script>";
    // mysqli_close($con);
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    $sql="insert into users (id, Name, UserName, EmailId, UserPassword, IsActive) values ();";
    // $query=mysqli_query($con, "call sp_registration(`$id`,'$name','$username',$email','$password','$isactive')");
    $query=mysqli_query($con,$sql);
    if ($query) {
      echo "<script>alert('Новый садовый участок успешно добавлен');</script>";
      echo "<script>window.location.href='createuser.php'</script>";
    } else {
      echo "<script>alert('Что-то пошло не так!. Попробуйте еще раз.');</script>";
    }
  }
/*
?>

