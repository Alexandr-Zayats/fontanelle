<?php
  namespace Phppot;
  //setlocale(LC_ALL, 'uk_UA.utf8');

  session_start();
  # error_reporting(0);
  require_once __DIR__ . '/../lib/UserModel.php';
  $userModel = new UserModel();

  //print_r($_SESSION['sourcePage']);
  //print('<br>');
  //
  if (! empty($_SERVER)) {
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI']) == false) {
      if ( $_SERVER['HTTP_REFERER'] != end($_SESSION['sourcePage']) ) {
        if(isset($_SESSION['return'])) {
          unset($_SESSION['return']);
        } elseif (isset($_SESSION['subpage'])) {
          $_SESSION['sourcePage'][] = $_SERVER['HTTP_REFERER'];
          //print_r($_SESSION['sourcePage']);
         //print('<br>');
  	}
      }
    }
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
    $_SESSION['uid'] = intval($uid);
  }

  if (isset($cid)) {
    $_SESSION['cid'] = intval($cid);
  }
  if (isset($cType)) {
    $_SESSION['cType'] = $cType;
  }

  if(!isset($_SESSION['allowedUser']) || empty($_SESSION['allowedUser'])) {
    $_SESSION['allowedUser'] = array('admin');
  }


  // Check login
  if(isset($_POST['login']) || isset($_SESSION['password'])) {
    if(!isset($_SESSION['password'])) {
      $password = md5($loginpassword);
    }
    $user = $userModel->call('userLogin', "'$username','$password'");

    if(empty($user)) {
      echo "<script>alert('Неверный ЛОГИН или ПАРОЛЬ');</script>";
      header('location:logout.php');
    } else {
      if(isset($_SESSION['password'])) {
        if (!in_array($_SESSION['loginType'], $_SESSION['allowedUser'])) {
          header('location:logout.php');
        }
      } else {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['sourcePage'] = array();
      }
      // START NEW session
      $_SESSION['id'] = intval($user[0]['id']);
      $_SESSION['userName'] = $user[0]['userName'];
      $_SESSION['Name'] = $user[0]['Name'];
      $_SESSION['loginType'] = $user[0]['loginType'];
      $_SESSION['startPage'] = $user[0]['url'];
      if($_SESSION['loginType'] == 'regularUser') {
        $_SESSION['uid'] = $_SESSION['id'];
        $uid =  $_SESSION['id'];
      }
      if(!isset($_SESSION['password'])) {
        $_SESSION['password'] = $password;
        header('location:' . $_SESSION['startPage']);
      }
    }
  } else {
    header('location:'.$_SERVER['HTTP_ORIGIN'].'/logout.php');
  }
  
  function destPage() {
    $page = array_pop($_SESSION['sourcePage']);
    $_SESSION['return'] = true;
    if(empty($page)) { $page = '/'; }
    return $page;
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
      <form class='user' name='im-$value' id='im-$value' action='$action' method='post'>
        <input type='hidden' name='$name' placeholder='' value='$value'>
        <a class='nav-link' style='cursor:pointer' onclick='submit(\"im-$value\")'>
          <i class='fas fa-fw fa-user'></i>
          <span>$title</span>
        </a>
      </form>";
  }
?>
