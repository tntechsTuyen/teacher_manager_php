<?php include_once("utils/MySQLUtils.php"); ?>

<?php 
	class ClassRoomModel{
		function __construct(){
			$this->db = new MySQLUtils();
		}

		public function selectAll(){
			$query = "
			SELECT id, code, point 
			FROM class_room";
			return $this->db->selectList($query, null);
		}

		public function selectList($codes = array()){
			$codesParam = str_repeat("?,", count($codes)-1) . "?";
			$query = "
			SELECT id, code, point 
			FROM class_room
			WHERE code IN ($codesParam) ";
			return $this->db->selectList($query, $codes);
		}

		public function selectOne($id){
			$query = "
			SELECT id, code, point 
			FROM class_room
			WHERE id = :id ";
			$param = array(
				'id' => $id
			);
			return $this->db->selectOne($query, $param);
		}

		public function selectListWithPoint(){
			$query = "
				SELECT id, code, point 
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

		public function update($code, $point = 0){
			$query = "
			UPDATE class_room 
			SET point = :point 
			WHERE code = :code ";
			$param = array(
				'code' => $code,
				'point' => $point
			);
			return $this->db->update($query, $param);
		}


	}
?>