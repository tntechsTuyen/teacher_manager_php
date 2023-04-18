<?php include_once("models/ClassRoomModel.php") ?>
<?php include_once("libs/PHPExcel/Classes/PHPExcel/IOFactory.php"); ?>
<?php 
	class ClassRoomController{
		public function __construct(){
			$this->classRoomModel = new ClassRoomModel();
		}

		public function getDataExcel(){
			$raws = array();
			$inputFileName = './data/data.xlsx';
			//  Read your Excel workbook
			try {
			    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
			    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$startIndex = 12;
			$rowCount = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
			for($i = $startIndex; $i < $rowCount; $i++){
				$code = $sheet->getCellByColumnAndRow(0,$i)->getValue();
				$name = $sheet->getCellByColumnAndRow(1,$i)->getValue();
				$numberOfCredits = $sheet->getCellByColumnAndRow(2,$i)->getValue();
				$numberOfPeriods = $sheet->getCellByColumnAndRow(3,$i)->getValue();
				$numberOfHour = $sheet->getCellByColumnAndRow(4,$i)->getValue();
				$className = $sheet->getCellByColumnAndRow(5,$i)->getValue();
				$studentCount = $sheet->getCellByColumnAndRow(6,$i)->getValue();
				$teacherName = $sheet->getCellByColumnAndRow(7,$i)->getValue();


				if(is_null($className) || $className == '') break;
				if(is_null($teacherName) || $teacherName == '') continue;
				
				if($code == "TH1508" || $code == "TH1509"){
					$teachers = explode("\n",$teacherName);
					foreach ($teachers as $key => $teacher) {
						if(is_null($teacher) || $teacher == '') break;
						$raws[] = array(
							"code" => $code,
							"name" => $name,
							"numberOfCredits" => $numberOfCredits,
							"numberOfPeriods" => $numberOfPeriods,
							"numberOfHour" => $numberOfHour,
							"className" => $className,
							"studentCount" => $studentCount,
							"teacherName" => $teacher,
							"point" => 0
						);	
					}
				}else{
					$raws[] = array(
						"code" => $code,
						"name" => $name,
						"numberOfCredits" => $numberOfCredits,
						"numberOfPeriods" => $numberOfPeriods,
						"numberOfHour" => $numberOfHour,
						"className" => $className,
						"studentCount" => $studentCount,
						"teacherName" => $teacherName,
						"point" => 0
					);
				}
			}
			return $raws;
		}

		public function sync(){
			//TODO: Sync data from excel
			$raws = $this->getDataExcel();
			//TODO: Insert to database
			$classList = $this->classRoomModel->selectAll();
			$tmpRaws = array_map(function ($obj) { return $obj['className']; }, $raws);
			$codes = array_map(function ($obj) { return $obj['code']; }, $classList);
			$newCodes = array_diff($tmpRaws, $codes);
			if(count($newCodes) > 0){
				foreach ($newCodes as $key => $value) {
					$this->classRoomModel->insert($value);
				}
			}
			return $tmpRaws;
		}

		public function goList(){
			$raws = $this->getDataExcel();
			$classList = $this->classRoomModel->selectListWithPoint();
			$classMap = array();
			if(count($classList) > 0){
				foreach ($classList as $key => $value) {
					$classMap[$value['code']] = $value['point'];
				}
			}

			$rawsMap = array();
			foreach ($raws as $key => $item) {
				if(is_null($rawsMap[$item['teacherName']])){
					$rawsMap[$item['teacherName']] = array();
				}
				if(!is_null($classMap[$item['className']])){
					$item['point'] = $classMap[$item['className']];
				}
				$rawsMap[$item['teacherName']][] = $item;
			}

			include_once("views/class_room_list.php");
		}

		public function goDetail(){
			$username = $_SESSION['username'];
			$raws = $this->getDataExcel();
			$classList = $this->classRoomModel->selectListWithPoint();
			if(count($classList) > 0){
				foreach ($classList as $key => $value) {
					$classMap[$value['code']] = $value['point'];
				}
			}

			$rawsMap = array();
			foreach ($raws as $key => $item) {
				if($item['teacherName'] == $username){
					if(is_null($rawsMap[$item['teacherName']])){
						$rawsMap[$item['teacherName']] = array();
					}
					if(!is_null($classMap[$item['className']])){
						$item['point'] = $classMap[$item['className']];
					}
					$rawsMap[$item['teacherName']][] = $item;	
				}
			}
			include_once("views/class_room_detail.php");
		}

		public function update(){
			$code = (isset($_POST['class_code'])) ? $_POST['class_code'] : null;
			$point = (isset($_POST['point'])) ? $_POST['point'] : 0;
			if($code == null){
				$_SESSION['mess'] = "Dữ liệu không hợp lệ";
			}else{
				$this->classRoomModel->update($code, $point);
				$_SESSION['mess'] = "Cập nhật thành công";
			}
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}

		public function login(){
			include_once("views/login.php");
		}

		public function submitLogin(){
			$username = (isset($_POST['username'])) ? $_POST['username'] : null;
			if($username == 'admin'){
				$_SESSION['username'] = $username;
 				$_SESSION['mess'] = "Đăng nhập thành công";
				header("Location: ?m=goList");
			}else{
				$_SESSION['username'] = $username;
				$_SESSION['mess'] = "Đăng nhập thành công";
				header("Location: ?m=goDetail");
			}
		}

		public function logout(){
			unset($_SESSION['username']);
			header("Location: ?m=login");
		}
	}
?>