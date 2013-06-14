<html>
	<header>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</header>
	<body>
		<table width="300" border="0" align="center" cellpadding="0" cellspacing="1">
			<tr>
				<td>
				<form name="form1" method="post" action="upload_image_process.php" enctype="multipart/form-data">
					<table width="100%" class="image_upload_form" border="0" cellspacing="1" cellpadding="3">
						<tr>
							<td colspan="3"><strong>Upload your score</strong></td>
						</tr>
						<tr>
							<td>Image score</td>
							<td>:</td>
							<td>
							<input name="image_score" type="file" id="image_score">
							</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td>
							<input name="email" type="text" id="email">
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
							<input type="submit" name="btnSubmit" value="Sent">
							</td>
						</tr>
					</table>
				</form></td>
			</tr>
		</table>
	</body>
</html>