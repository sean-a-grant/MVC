<!DOCTYPE html>
<html>
	<head>
		<title>Example template file</title>
	</head>
	<body>
		This is an example of what your template file should look like. Notice how there is limited PHP executed inside of the file. The only things you should check are if variables are set and if so, echo them.<br>
		Here is what the request model file produced:<br>
		<?php
		if(isset($content)){
			echo $content;
		} else{
			echo "No content was set.";
		}
		?>
	</body>
</html>