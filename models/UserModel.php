<?php include_once("utils/MySQLUtils.php"); ?>
<?php 
	class UserModel{
		function __construct(){
			$this->db = new MySQLUtils();
		}
		
		public function selectByUsername($username){
			$query = "
			SELECT id, username, password
			FROM user
			WHERE username = :username ";
			$param = array(
				'username' => $username
			);
			return $this->db->selectOne($query, $param);
		}

	}
?>