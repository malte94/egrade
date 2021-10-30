<?php
require_once ("../config/config.php");
require_once (ROOT_PATH."vendor/autoload.php");
require_once (ROOT_PATH."class/pdf/nrw_interface.php");
require_once (ROOT_PATH."/class/pdf/PDF_Generator_RP_V1.php");

$pdf = new \Mpdf\PDF_Generator_NRW_C1_1_V1();

echo $pdf->out();