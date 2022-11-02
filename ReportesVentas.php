<?php
require_once 'helpers/utils.php';
require_once 'cxxxx/HomeCxxxx.php';
require_once 'models/UxxxxxCxxx.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;


class HistoricoController
{
	public function index()
	{
		Utils::checkSession();
		require 'views/historico/historico.php';
	}

	public function funcion1()
	{

		$fecha_i = $_POST['date1'];
		$fecha_f = $_POST['date2'];

		$centrosPre = new BxxxxxxVxxxx();
		$centrosPrepagos = $centrosPre->getAll($fecha_i, $fecha_f);

		$datosObtenidos = new HxxxCxxxxx();
		$reporteCentro = $datosObtenidos->getDesgloseCentros($centrosPrepagos, $fecha_i, $fecha_f);

		echo json_encode($reporteCentro);
	}


	public function funcion2()
	{
		$fecha_i = $_POST['date1'];
		$fecha_f = $_POST['date2'];

		$coaches = new UxxxCxxxx();
		$coaches = $coaches->getCoaches();


		$desgloseHoraCoach = $this->desgloseHoraCoach($coaches, $fecha_i, $fecha_f);

		echo json_encode($desgloseHoraCoach);
	}

	public function funcion3($getCoach, $fecha_i, $fecha_f)
	{
		
		$ventashoracoaches = new Bxxxxx();
		
		while ($coach = $getCoach->fetch_object()) {
			$coachId = $coach->Id;
			
			$getCoachHora = $ventashoracoaches->gethoraventaCoach($fecha_i, $fecha_f, $coachId);
			$horasCoach[$coach->Nombre] = Utils::segmentaHoras($getCoachHora);
		}
		// $gethoraventaCoach
		return $horasCoach;
	}

	public function Sucursal()
	{
		$fecha_i = $_POST['date1'];
		$fecha_f = $_POST['date2'];

		$sector = new Usuario();
		$getSectores = $sector->getSectores($fecha_i, $fecha_f);
		$desglosector = new HomeController();
		$getdesgloseSector = $desglosector->getDesgloSector($getSectores, $fecha_i, $fecha_f);
		echo json_encode($getdesgloseSector);
	}

	/************************************ Con esta fucnion creo el Excel ************************************** */

	public function generarExcel(){
		$fecha_i = $_POST['date1'];
		$fecha_f = $_POST['date2'];
		$ventas = new Bitacora();
		$ventaCoach = $ventas->getVentasCoach($fecha_i, $fecha_f);
		$reporteCoach = HomeController::getDesgloseCoaches($ventaCoach, $fecha_i, $fecha_f);

		$filename = 'reporte.csv';

		$spreadsheet = new Spreadsheet();
		$Excel_writer = new Csv($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$activeSheet->setCellValue('A', 'nombre');
		$activeSheet->setCellValue('B', 'venta');
		$activeSheet->setCellValue('c', 'dato1');
		$activeSheet->setCellValue('D', 'base');
		$activeSheet->setCellValue('E', 'Total');
		$activeSheet->setCellValue('F', 'Asistencia');
		$activeSheet->setCellValue('G', 'Factor');
		$activeSheet->setCellValue('H', 'Horas Conexion');
		$activeSheet->setCellValue('I', 'horas');
		$activeSheet->setCellValue('J', 'porcentaje');

		
		//echo json_encode($reporteCoach);
		foreach ($reporteCoach as $indice => $reporte) {
			//var_dump($indice); 
			
			if($$indice){
				$i++;
				$activeSheet->insertNewRowBefore($i, 1);

			}

			$coach 	 	 = $reporte["nombre"];
			$pago 	 	 = $reporte["venta"];
			$datos  	 = $reporte["dato1"];
			$base   	 = $reporte["base"];
			$total 	  	 = $reporte["total"];
			$asistencia 	 = $reporte["asistencia"];
			$factor	  	 = $reporte["fac"];
			$horasconexion = $reporte["conexion"];
			$horas 	   	 = $reporte["horas"];
			$porcentaje      	 = $reporte["porcentaje"];
			
			$activeSheet->setCellValue("A".$i, $coach);
			$activeSheet->setCellValue("B".$i, $pago);
			$activeSheet->setCellValue("C".$i, $datos);
			$activeSheet->setCellValue("D".$i, $base);
			$activeSheet->setCellValue("E".$i, $total);
			$activeSheet->setCellValue("F".$i, $asistencia);
			$activeSheet->setCellValue("G".$i, $factor);
			$activeSheet->setCellValue("H".$i, $horasconexion);
			$activeSheet->setCellValue("I".$i, $horas);
			$activeSheet->setCellValue("J".$i, $porcentaje);
			
		}
		exit();
		
		$filename = 'products.csv';

		header('Content-Type: application/text-csv');
		header('Content-Disposition: attachment;filename='. $filename);
		header('Cache-Control: max-age=0');
		$Excel_writer->save('php://output');
		$button = '<a href="$Excel_writer" class="btn btn-primary disabled" tabindex="-1" role="button" aria-disabled="true">Primary link</a>';
		
	}
}

?>