<?php
include ("database.php");

if (isset($_POST['email'])) {

	if ($_FILES['image_score']['name'] != NULL) {
		$filename = $_FILES['image_score']['name'];
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" || $ext == "png") && ($_FILES["image_score"]["size"] < 100000)) {
			$name = date('YmdHis') .rand(111111, 999999).".".$ext;
			move_uploaded_file($_FILES['image_score']['tmp_name'], "../upload/" . $name);
			echo "<h1>Sent image successful</h1>";

			$url = '../upload/'.$name;
			echo $url;
			$facebook_id = "1234567";

			$db = new database();
			$conn = $db -> connectToDB();

			$email = trim($_POST['email']);

			//Search isExit facebook id on user table

			try {

				$sql = "SELECT * FROM `kb_viva_rouletta_fb`.`user` WHERE facebook_id = :facebook_id";
				$stmt = $conn -> prepare($sql);
				$stmt -> bindValue(":facebook_id", $facebook_id);

				// call the stored procedure
				$stmt -> execute();
				$isExisted = false;
				$user_id = 0;
				while ($rs = $stmt -> fetch(PDO::FETCH_OBJ)) {
					if (isset($rs -> facebook_id)) {
						$isExisted = true;
						$user_id = $rs -> id;
					}
				}

				if ($isExisted) {//Insert the user id to image tbl
				
					$stmt1 = $conn -> prepare("INSERT INTO `kb_viva_rouletta_fb`.`user_images` (
							 `user_id`, `image_url`)
							 VALUES (:new_user_id,
							 :url)");
					$stmt1 -> bindValue(":new_user_id", $user_id);
					$stmt1 -> bindValue(":url", $url);
					// call the stored procedure
					$stmt1 -> execute();
					
					
					
				} else {//create new user
					$stmt1 = $conn -> prepare("INSERT INTO `kb_viva_rouletta_fb`.`user` (
							 `facebook_id`)
							 VALUES (:facebook_id)");
					$stmt1 -> bindValue(":facebook_id", $facebook_id);
					// call the stored procedure
					$stmt1 -> execute();
					
					$last_user_id = $conn->lastInsertId();
					
					$stmt1 = $conn -> prepare("INSERT INTO `kb_viva_rouletta_fb`.`user_images` (
							 `user_id`, `image_url`)
							 VALUES (:new_user_id,
							 :url)");
					$stmt1 -> bindValue(":new_user_id", $last_user_id);
					$stmt1 -> bindValue(":url", $url);
					// call the stored procedure
					$stmt1 -> execute();
				}

			} catch (PDOException $e) {
				print "Error!: " . $e -> getMessage() . "<br/>";
				die();
			}

			/*
			 //insert to database
			 //insert user table
			 $sql = "INSERT INTO `kb_viva_rouletta_fb`.`user` (
			 `username`, `email`, `password`, `nickname`, `birthday`,
			 `gender`, `phonenumber`, `language`, `country`, `address`)
			 VALUES ('" . $username . "',
			 '" . $email . "',
			 '" . $passsword . "','" . $nickname . "', '" . $birthdate . "',
			 " . $gender . ",
			 '" . $phone . "',
			 '" . $language . "',
			 '" . $language . "',
			 '" . $address . "')";

			 $result = mysql_query($sql, $conn);
			 $new_user_id = mysql_insert_id();
			 //Insert image table

			 $sql2 = "INSERT INTO `kb_viva_rouletta_fb`.`user_images` (
			 `user_id`, `image_url`)
			 VALUES ('" . $new_user_id . "',
			 '" . $url . "')";

			 $result2 = mysql_query($sql2, $conn);
			 *
			 */
		} else {
			echo "<h1>Your image is not valid</h1>";
		}

	} else {
		echo "<h1>Your image is not valid</h1>";
	}
}
?>