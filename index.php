<?php 
	use Dompdf\Dompdf;
	use Dompdf\Options;
	require 'vendor/autoload.php';
	$options = new Options();
	$options->set('defaultFont', 'Arabic');
	$options->set('chroot', realpath(''));
	$dompdf = new Dompdf($options);
	require_once 'vendor/src/Arabic.php';
	$Arabic = new ArPHP\I18N\Arabic();

	$html = '  ستخدام ';
	$p = $Arabic->arIdentify($html);
	for ($i = count($p)-1; $i >= 0; $i-=2) {
	$utf8ar = $Arabic->utf8Glyphs(substr($html, $p[$i-1], $p[$i] - $p[$i-1]));
	$html   = substr_replace($html, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
	}
	$dompdf->loadHtml('
<!DOCTYPE html>
<head><style>
body{
	font-size: 100px;
	text-align:right;
}

</style></head>
<body>
 '.$html.'
</body></html>
	');
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	$dompdf -> stream("NEXAMPLE", array("Attachment" => false));
?>

