<?php 
	class MySQLUtils {
		private static $conn = null;
		private $servername = "localhost";
		private $username = "root";
		private $password = "12345678";

		function __construct() {
			try {
			  self::$conn = new PDO("mysql:host=$servername;dbname=vinhlong_uni;port=3306", $this->username, $this->password);
			  // set the PDO error mode to exception
			  self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {

			}
		}

		public function selectList($query, $param = null){
			$stmt = self::$conn->prepare($query);
		  	$stmt->execute($param);
		  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
		  	$result = $stmt->fetchAll();
		  	return $result;
		}

		public function selectOne($query, $param = null){
			$stmt = self::$conn->prepare($query);
		  	$stmt->execute($param);
		  	$stmt->setFetchMode(PDO::FETCH_ASSOC);
		  	$result = $stmt->fetch();
		  	return $result;
		}

		public function insert($query, $param = null){
			$stmt = self::$conn->prepare($query);
		  	$stmt->execute($param);
		  	$id = self::$conn->lastInsertId();
		  	return $id;
		}

		public function update($query, $param = null){
			$stmt = self::$conn->prepare($query);
		  	$stmt->execute($param);
		  	return true;
		}

		public function delete($query, $param = null){
			$stmt = self::$conn->prepare($query);
		  	$stmt->execute($param);
		  	return true;
		}

		public function disconnect(){
			self::$conn = null;
		}
	}
?>