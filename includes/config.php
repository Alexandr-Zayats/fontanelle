<?php
  namespace Phppot;
  //setlocale(LC_ALL, 'uk_UA.utf8');

  session_start();
  error_reporting(0);

  require_once __DIR__ . '/../lib/UserModel.php';
  $userModel = new UserModel();
 
  if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI']) == false) {
    $_SESSION['sourcePage'] = $_SERVER['HTTP_REFERER'];
  }

  foreach ($_SESSION as $key => $value) {
    ${$key} = $value;
  }
  foreach ($_GET as $key => $value) {
    ${$key} = $value;
  }
  foreach ($_POST as $key => $value) {
    ${$key} = $value;
  }

  if (isset($uid)) {
    $_SESSION['uid'] = $uid;
  }

  if (isset($cid)) {
    $_SESSION['cid'] = $cid;
  }

  // Check login
  if(isset($_POST['login']) || isset($_SESSION['loginpassword'])) {
    if(!isset($_SESSION['password'])) {
      $password = md5($loginpassword);
    }

    $user = $userModel->call('userLogin', "'$username','$password'");
    if(empty($user)) {
      echo "<script>alert('Неверный ЛОГИН или ПАРОЛЬ');</script>";
      header('location:logout.php');
    } else {
      $_SESSION['id'] = $user[0]['id'];
      $_SESSION['userName'] = $user[0]['userName'];
      $_SESSION['Name'] = $user[0]['Name'];
      $_SESSION['loginType'] = $user[0]['loginType'];
      if(!isset($_SESSION['password'])) {
        $_SESSION['password'] = $password;
        print_r($_SESSION);
        header('location:' . $user[0]['url']);
      }
    }
  }

  function dateFormat(String $dat) {
    $monthes = array(
      1 => 'Січня', 2 => 'Лютого', 3 => 'Березня', 4 => 'Квітня',
      5 => 'Травня', 6 => 'Червня', 7 => 'Липня', 8 => 'Серпня',
      9 => 'Вересня', 10 => 'Жовня', 11 => 'Лютого', 12 => 'Грудня'
    );

    $_date[] = strtolower(date("d",strtotime($dat)));
    $_date[] = $monthes[(date('n', strtotime($dat)))];
    $_date[] = strtolower(date("Y",strtotime($dat))) . "р.";
    $curDate = join(" ", $_date);

    return $curDate;
  }

  function dateDiffInDays($date1, $date2) {
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);
  
    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return abs(round($diff / 86400));
  }

  function formSubmit($name, $value, $title, $action) {
    echo "
      <form class='user' id='$value' action='$action' method='post'>
        <input type='hidden' name='$name' placeholder='' value='$value'>
        <a class='nav-link' style='cursor:pointer' onclick='submit($value)'>
          <i class='fas fa-fw fa-user'></i>
          <span>$title</span>
        </a>
      </form>";
  }
