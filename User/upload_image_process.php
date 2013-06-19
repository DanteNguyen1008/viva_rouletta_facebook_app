<?php
include ("database.php");

if ($_FILES['image_score']['name'] != NULL) {
	$filename = $_FILES['image_score']['name'];
	$ext = substr($filename, strrpos($filename, '.') + 1);
	if (($ext == "jpg" || $ext == "png") && ($_FILES["image_score"]["size"] < 100000)) {

		$facebook_id = "9999999999";

		$db = new database();
		$conn = $db -> connectToDB();

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
							 `user_id`)
							 VALUES (:new_user_id)");
				$stmt1 -> bindValue(":new_user_id", $user_id);
				// call the stored procedure
				$stmt1 -> execute();

			} else {//create new user
				$stmt1 = $conn -> prepare("INSERT INTO `kb_viva_rouletta_fb`.`user` (
							 `facebook_id`)
							 VALUES (:facebook_id)");
				$stmt1 -> bindValue(":facebook_id", $facebook_id);
				// call the stored procedure
				$stmt1 -> execute();

				$last_user_id = $conn -> lastInsertId();

				$stmt1 = $conn -> prepare("INSERT INTO `kb_viva_rouletta_fb`.`user_images` (
							 `user_id`)
							 VALUES (:new_user_id)");
				$stmt1 -> bindValue(":new_user_id", $last_user_id);
				// call the stored procedure
				$stmt1 -> execute();
			}

		} catch (PDOException $e) {
			print "Error!: " . $e -> getMessage() . "<br/>";
			die();
		}

	} else {
		echo "<h1>Your image is not valid</h1>";
	}

} else {
	echo "<h1>Your image is not valid</h1>";
}
?>