<?php

    $url = $_SERVER['REQUEST_URI'];
    $uri = substr($url, 1);
    $uri = preg_replace('/\?.*/', '', $uri);

    function __autoload($class_name){
        $class_name = str_replace("_","/",$class_name);
        include $class_name.'.php';
    }

    new System_routes($uri);

?>

<html>
	<head>
		<link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
	</head>
	<body>
		<div class = "container">
			<form method = "post" action = "/import_camp" enctype="multipart/form-data" class="form-inline" role="form">
				<h4>Campaign upload</h4>
				 <div class="form-group">
				    <label for="file">Upload file:</label>
				    <input type="file" class="form-control" name = "file" id="file">
				  </div>
				  <div class="form-group">
				    <input type="submit" class="btn" name = "submit">
				  </div>
			</form>
		</div>
	</body>
</html>