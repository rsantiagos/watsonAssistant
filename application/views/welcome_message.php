<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
		height: 100%;
	}

	pre {
		width: 80%;
		height: 300px;
		margin: 0 auto;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</head>
<body>

	<div class="container">
		<pre><code><?= $grafica ?></code></pre>
	</div>

	


	<div id="chartdivd" style="width: 640px; height: 400px; display: none;"></div>

	<script type="text/javascript" src="assets/amcharts/amcharts.js"></script>
	<script type="text/javascript" src="assets/amcharts/serial.js"></script>

	<script type="text/javascript">
		<?= $grafica ?>
	</script>


	<script type="text/javascript">
			function mostrarGrafica() 
			{
				 
				 $('#chartdivd').show(3000);
				 $('.chartdivd').show("slow");
			}

			function ocultarGrafica()
			{
				 
				 $('#chartdivd').hide(3000);
				 $('.chartdivd').hide("fast"); 
			}
		mostrarGrafica();
	</script>


	

</body>
</html>