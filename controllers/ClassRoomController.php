<?php include_once("models/ClassRoomModel.php") ?>
<?php include_once("models/UserModel.php") ?>
<?php include_once("libs/PHPExcel/Classes/PHPExcel/IOFactory.php"); ?>
<?php 
	class ClassRoomController{
		public function __construct(){
			$this->classRoomModel = new ClassRoomModel();
			$this->userModel = new UserModel();
		}

		public function getDataExcel(){
			$raws = array();
			$inputFileName = 'data/data.xlsx';
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
				$point = 0;


				if(is_null($className) || $className == '') break;
				if(is_null($teacherName) || $teacherName == '') continue;
				
				if($numberOfPeriods != 0 || $code == 'TH1508' || $code == 'TH1509'){
					if($studentCount < 20){
						$point = 1.1;
					}else if($studentCount >= 20 && $studentCount < 30){
						$point = 1.2;
					}else if($studentCount >= 30 && $studentCount < 40){
						$point = 1.3;
					}else if($studentCount >= 40 && $studentCount < 50){
						$point = 1.4;
					} else {
						$point = 1.5;
					}
				}else{
					if($studentCount < 11){
						$point = 1.1;
					}else if($studentCount >= 11 && $studentCount < 15){
						$point = 1.2;
					} else {
						$point = 1.3;
					}
				}

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
							"point" => $point
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
						"point" => $point
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
			$_SESSION['mess'] = "Cập nhật thành công";
			header("Location: " . $_SERVER["HTTP_REFERER"]);
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

			$tttn = $this->classRoomModel->selectByCode("TTTN");

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
			$studentCount = (isset($_POST['student_count'])) ? $_POST['student_count'] : 0;
			$numberOfPeriods = 0;

			if ($studentCount <= 4) {
				$numberOfPeriods = 1;
			}else if($studentCount > 4 && $studentCount <= 10){
				$numberOfPeriods = 3;
			}else {
				$numberOfPeriods = 5;
			}

			if($code == null){
				$_SESSION['mess'] = "Dữ liệu không hợp lệ";
			}else{
				$classInfo = $this->classRoomModel->selectByCode($code);
				if($classInfo == null) $this->classRoomModel->insert($code);
				$this->classRoomModel->update($code, $studentCount, $numberOfPeriods);
				$_SESSION['mess'] = "Cập nhật thành công";
			}
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}

		public function login(){
			include_once("views/login.php");
		}

		public function submitLogin(){
			$username = (isset($_POST['username'])) ? $_POST['username'] : null;
			$password = (isset($_POST['password'])) ? $_POST['password'] : null;
			$role = (isset($_POST['role'])) ? $_POST['role'] : null;
			$passEncode = md5($password);
			$user = $this->userModel->selectByUsername($username);

			if(!is_null($user) && $role == 1){
				if($passEncode == $user['password']){
					$_SESSION['username'] = $username;
	 				$_SESSION['mess'] = "Đăng nhập thành công";
					header("Location: ?m=goList");
				}else{
	 				$_SESSION['mess'] = "Thông tin không hợp lệ";
					header("Location: ?m=login");
				}
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