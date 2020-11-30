<?php

	
	class Customers
	{
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $database = "crudphpoop";
		public $con;

		//Database connection
		
		public function __construct()
		{
			$this->con = new mysqli($this->servername,$this->username,$this->password,$this->database);
			if(mysqli_connect_error()){
				trigger_error("failed to connect database" . mysqli_connect_error());
			}else{
				return $this->con;
			}

		}

		//Insert Data

		public function insertData($post)
		{
			$name = $this->con->real_escape_string($_POST['name']);
			$email = $this->con->real_escape_string($_POST['email']);
			$username = $this->con->real_escape_string($_POST['username']);
			$password = $this->con->real_escape_string(md5($_POST['email']));
			$query = "INSERT INTO customers(name,email,username,password) VALUES('$name','$email','$username','$password')";
			$sql = $this->con->query($query);
			if($sql == true){
				header("Location:index.php?msg1=insert");
			}else{
				echo "Registered failed try again!";
			}
		}

		//Fetch Data

		public function displayData()
		{
			$query = "SELECT * FROM customers";
			$result = $this->con->query($query);
			if($result->num_rows>0){
				$data = array();
				while($row = $result->fetch_assoc()){
					$data[] = $row;
				}
				return $data;
			}else{
				echo "no records found";
			}
		}

		//Fetch single data for edit

		public function displayRecordById($id)
		{
			$query = "SELECT * FROM customers WHERE id= '$id'";
			$result = $this->con->query($query);
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				return $row;
			}else{
				echo "Record not found";
			}
		}

		//update customer data

		public function updateRecord($postData)
		{
			$name = $this->con->real_escape_string($_POST['uname']);
			$email = $this->con->real_escape_string($_POST['uemail']);
			$username = $this->con->real_escape_string($_POST['upname']);
			$id = $this->con->real_escape_string($_POST['id']);

			if(!empty($id) && !empty($postData)){
				$query = "UPDATE customers SET name= '$name', email = '$email',username = '$username' WHERE id = '$id'";
				$sql = $this->con->query($query);
				if($sql == true){
					header("Location:index.php?msg2=update");
				}else{
					echo "registration updated failed";
				}
			}

		}

			//delete data 

			public function deleteRecord($id)
			{
				$query = "DELETE FROM customers WHERE id = '$id'";
				$sql = $this->con->query($query);
				if($sql==true){
					header("location:index.php?msg3=delete");
				}else{
					echo "record not deleted";
				}
			}

		
	}

?>