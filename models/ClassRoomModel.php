<?php include_once("utils/MySQLUtils.php"); ?>

<?php 
	class ClassRoomModel{
		function __construct(){
			$this->db = new MySQLUtils();
		}

		public function selectAll(){
			$query = "
			SELECT id, code, point, student_count, number_of_periods, grp, location
			FROM class_room";
			return $this->db->selectList($query, null);
		}

		public function selectList($codes = array()){
			$codesParam = str_repeat("?,", count($codes)-1) . "?";
			$query = "
			SELECT id, code, point, student_count, number_of_periods, grp, location
			FROM class_room
			WHERE code IN ($codesParam) ";
			return $this->db->selectList($query, $codes);
		}

		public function selectOne($id){
			$query = "
			SELECT id, code, point, student_count, number_of_periods, grp, location
			FROM class_room
			WHERE id = :id ";
			$param = array(
				'id' => $id
			);
			return $this->db->selectOne($query, $param);
		}

		public function selectByCode($code){
			$query = "
			SELECT id, code, point, student_count, number_of_periods, grp, location
			FROM class_room
			WHERE code = :code ";
			$param = array(
				'code' => $code
			);
			return $this->db->selectOne($query, $param);
		}

		public function selectLikeCode($code){
			$query = "
			SELECT id, code, point, student_count, number_of_periods, grp, location
			FROM class_room
			WHERE code LIKE :code ";
			$param = array(
				'code' => "%$code%"
			);
			return $this->db->selectList($query, $param);
		}

		public function selectListWithPoint(){
			$query = "
				SELECT id, code, point, student_count, number_of_periods, grp, location
				FROM class_room WHERE point > 0";
			return $this->db->selectList($query, null);
		}

		public function insert($code){
			$query = "INSERT INTO class_room (code) VALUES (:code) ";
			$param = array(
				'code' => $code
			);
			return $this->db->insert($query, $param);
		}

		public function update($code, $studentCount, $numberOfPeriods, $group, $location){
			$query = "
			UPDATE class_room 
			SET student_count = :studentCount 
			, number_of_periods = :numberOfPeriods 
			, grp = :group
			, location = :location
			WHERE code = :code ";
			$param = array(
				'code' => $code,
				'studentCount' => $studentCount,
				'numberOfPeriods' => $numberOfPeriods,
				'group' => $group,
				'location' => $location
			);
			return $this->db->update($query, $param);
		}


	}
?>