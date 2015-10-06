<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SlimDwet MVC</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<?php if(!empty($this->View->getStyles())) : foreach($this->View->getStyles() as $style) : ?>
	<link rel="stylesheet" href="<?php echo $style; ?>">
	<?php endforeach; endif; ?>
</head>
<body>
	<div class="container-fluid">