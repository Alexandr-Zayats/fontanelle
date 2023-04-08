<?php
  namespace Phppot;
  include_once __DIR__ . '/../includes/config.php';
  include_once __DIR__ . '/includes/config.php';

$target_folder = 'uploads/' . $userData['id'];
$target_file = $target_folder . '/notice.pdf';

if(isset($_POST['close'])) {
  echo "<script>window.location.href='../cashier/debtors.php'</script>";
} elseif(isset($_POST['print'])) {
  echo "<script>window.location.href='registered-users.php'</script>";
} else {

  $phone="";
  if (preg_match('/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $userData['phone1'],  $matches )) {
    $phone="+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
  }
  if (preg_match( '/.*(\d{2})(\d{3})(\d{2})(\d{2})$/', $result['phone2'],  $matches)) {
    $phone=$phone."; "."+380 ($matches[1]) $matches[2]-$matches[3]-$matches[4]";
  }

  $time = strtotime(date('Y-m-d'));
  $final = date("Y-m-d", strtotime("+1 month", $time));
  $dueDate = dateFormat($final);
  $curDate = dateFormat(date('Y-m-d'));
  
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/../lib/customPdfGenerator.php';

  $pdf = new CustomPdfGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
  $pdf->setFontSubsetting(true);
  $pdf->SetFont('dejavusans', '', 12, '', true);
  // start a new page
  $pdf->AddPage();

  // date and invoice no
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>Дата: </b>" . $curDate);
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>-- ПОПЕРЕДЖЕННЯ -- </b>");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  // address
  $pdf->writeHTML("Кооперативна 1а,");
  $pdf->writeHTML("смт Бабинці,");
  $pdf->writeHTML("Бучанський р-н,");
  $pdf->writeHTML("Київська область, 07832");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  // bill to
  $pdf->writeHTML("<b>Попередження до:</b>", true, false, false, false, 'R');
  $pdf->writeHTML("вулиця " . $userData['street'] . ", ділянка №" . $userData['id'] . ",", true, false, false, false, 'R');
  $pdf->writeHTML($userData['Name'] . ",", true, false, false, false, 'R');
  $pdf->writeHTML("смт Бабинці, СМ Джерела, 07832", true, false, false, false, 'R');
  $pdf->writeHTML("тел.: " . $phone, true, false, false, false, 'R');
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

  // main text
  $pdf->writeHTML("Доводимо до Вашого відома, що станом на " . $curDate . " за Вашою садовою ділянкою наявні наступні порушення:", true, true, true, true, 'C');
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $cnt = 0;
  if($userData['fee'] < ($userData['Size'] * 100 * -2)) {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Iснує заборгованість по оплаті членських внесків в сумі " . $userData['fee'] . " грн.;\n");
  }
  if($userData['el'] < - 1000) {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Iснує заборгованість " . $userData['el'] . "грн. по оплаті за спожиту електроенергію (остання оплата від " . dateFormat($userData['verEl']) . ");\n");
  }
  if(isset($userData['verEl']) && $userData['verEl'] != "" && dateDiffInDays(date('Y-m-d'), $userData['verEl']) > 180) {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Не надані фото показників лічильника електроенергії, остання звірка -  " . dateFormat($userData['verEl']) . ";\n");
  }
  if($userData['wat'] < -1000 ) {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Існує заборгованість " . $userData['wat'] . "грн.  по оплаті за спожиту воду (остання оплата від " . dateFormat($userData['verWat']) . ";\n");
  }
  if(isset($userData['verWat']) && $userData['verWat'] != "" && dateDiffInDays(date('Y-m-d'), $userData['verWat']) > 180) {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Не надано показники лічильника споживання води, остання звірка - " . dateFormat($userData['verWat']) . ";\n");
  }
  if($userData['counterLocation'] == 'внутри') {
    $cnt++;
    $pdf->writeHTML("\t" . $cnt .". Наявні порушення п3.1 додатку №2 до Договору про обслуговування, а саме щодо місця встановлення приладів обліку споживання електроенергії.;\n");
  }

  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

  $pdf->writeHTML("Просимо Вас усунути вказані порушеня в термін до " . $dueDate . "\n\n");
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("У випадку ігнорування даного попередження, відповідно до умов Договору на обслуговування та Статуту СТ 'Ручейок' п.2.10,", true, true, true, true, 'W');
  $pdf->writeHTML("Правління Управляючого Кооперативу \"СТ 'Ручейок'\" буде вимушене припинити надання поcлуг з обслуговування Вашої садовоЇ ділянки.", true, true, true, true, 'W');
  $pdf->Write(0, "\n", '', 0, 'C', true, 0, false, false, 0);

  // invoice table starts here
  /*
  $header = array('ПОСЛУГА', 'ЗАБОРГОВАНІТЬ', 'РЕКОМЕНДАЦІЇ');
  $data = array(
    array('Сплата членьских внесків','-3242344','сплатити в місячний термін'),
    array('Показники лічильника елекстроенргії', 'останій раз подані','подати до')
  );
  $pdf->printTable($header, $data);
  $pdf->Ln();
  */

  // comments
  $pdf->SetFont('', '', 12);
  $pdf->Write(0, "\n\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("Повідомлення вручив: Член Правління _____________ /____________/");
  $pdf->Write(0, "\n\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("<b>Контакти:</b>");
  $pdf->writeHTML("Viber: <i>0960906226</i>");
  $pdf->writeHTML("Email: <i>info@rucheyok.org.ua</i>");
  $pdf->Write(0, "\n\n\n", '', 0, 'C', true, 0, false, false, 0);
  $pdf->writeHTML("Якщо у Вас залишилися питання, будь-ласка звертайтесь:", true, false, false, false, 'C');
  $pdf->writeHTML("СТ Ручейок, +380 (96) 090 62 26, info@rucheyok.org.ua", true, false, false, false, 'C');

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
