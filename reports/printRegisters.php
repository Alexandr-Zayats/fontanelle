<?php
  namespace Phppot;
  session_start();
  $_SESSION['subpage'] = true;

  include_once __DIR__ . '/includes/config.php';
  include_once __DIR__ . '/../includes/config.php';

  $target_folder = 'print/';
  $target_file = $target_folder .'registers.pdf';

  /*
  $pYear=date('Y');
  $pWeek='22';
  */

  if(isset($_POST['close'])) {
    header('location:' . destPage());
  
  } elseif(isset($_POST['print'])) {
    header("Location:registered-users.php");
  } else {

  $time = strtotime(date('Y-m-d'));
  $curDate = dateFormat(date('Y-m-d'));
  
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../lib/customPdfGenerator.php';

  $pdf = new \CustomPdfGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  $pdf->setFontSubsetting(true);
  $pdf->SetFont('dejavusans', '', 10, '', true);
  // start a new page
  $pdf->AddPage();

  // date and invoice no
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>Дата: </b>" . $curDate);
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>-- ВІДОМІСТЬ № " . $pYear . "/" . $pWeek . " -- </b>");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  // address
  $pdf->writeHTML("Кооперативна 1а,");
  $pdf->writeHTML("смт Бабинці,");
  $pdf->writeHTML("Бучанський р-н,");
  $pdf->writeHTML("Київська область, 07832");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

  // main text
  $query = $userModel->call('vedomost', "$pYear, $pWeek");
  $cnt=1; $sumTotal=0; $sumEl=0; $sumWat=0; $sumFee=0; $sumInc=0; $sumOthers=0; $data=array();
  $header = array('№', 'Ділянка', 'ПІБ', 'Призначення', 'Сума', 'Дата та час');
  foreach ($query as $result) {
    if ($result['dst'] == 'el') { $sumEl+=$result['sum']; $type='Електроенергія';}
    elseif ($result['dst'] == "wat") { $sumWat+=$result['sum']; $type='Вода';}
    elseif ($result['dst'] == "fee") { $sumFee+=$result['sum']; $type='Членські';}
    elseif ($result['dst'] == "inc") { $sumInc+=$result['sum']; $type='Вступні';}
    else { $sumOthers+=$result['sum']; $type='Інше';}

    array_push($data, array($cnt, $result['id'], $result['name'], $type, floatval($result['sum']), $result['date'])); 
    $sumTotal+=$result['sum'];
    $cnt++;
  }

  // array_push($data, array('', '', '', '', '', 'ВСЬОГО: '.$sumTotal));

  //print_r($data);

  $pdf->printTable($header, $data);
  $pdf->Ln();

  // save pdf file
  if (!file_exists($target_folder)) {
    mkdir($target_folder, 0777, true);
  }
  $pdf->Output(__DIR__ . '/' . $target_file, 'F');
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
</head>

<body class="bg-gradient-primary">
  <table width="80%" height="90%" align="center">
    <tr height="800">
      <td>
        <iframe src="<?php echo $target_file?>" height="100%" width="100%"></iframe>
      </td>
    </tr>
    <tr height="5%">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <td style="text-align:right">
          <form class="user" name="close" method="post">
            <button type="submit" name="close" class="btn btn-primary btn-user btn-block">
              Закрыть
            </button>
          </form>
        </td>
      </div>
    </tr>
  </table>
</body>
</html>
