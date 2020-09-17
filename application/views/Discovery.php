<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">
	#resultado {
      width: 75%;
      height: 500px;
      border: 1px solid lightgray;
      background-color: #000;
  }
	</style>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.19.1/vis.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.19.1/vis.min.css">
</head>
<body>
	<section class="content">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
          <div class="panel panel-bd lobidrag">
              <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane in active" id="axtel">
                        <div class="panel-body">
													<input type="hidden" name="consulta" id="consulta" value="<?php echo $query;?>">
                            <div id="resultado"></div>
                        </div>
                    </div>
               </div>
             </div>
         </div>
      </div>
    </div>
	</section>

	<script type="text/javascript">
		consultaDiscovery($("#consulta").val());
		function consultaDiscovery(consulta) {
		    $.ajax({
		        url: 'Welcome/discovery',
		        type: 'POST',
		        data: {consulta: consulta},
						success: function (response) {
								var msg = JSON.parse(response);
								pintarArania(msg);
			      },
						error: function (request, status, error) {
				        alert(request.responseText);
				    }
		    });
		}

		function pintarArania(msg){
			var dataMap = {
	        nodes: msg.nodesGen,
	        edges: msg.edgesGen
	    }
	    var nodes = new vis.DataSet(dataMap.nodes);
	    var edges = new vis.DataSet(dataMap.edges);
	    // create a network
	    var container = document.getElementById("resultado");

	    var data = {
	        nodes: nodes,
	        edges: edges
	    };
	    var options = {
	        nodes : {
	            font: {
	                color: '#FFFFFF',
	            },
	            physics: true,
	        },
	        groups: {
	            fallas: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome-old',
	                    code: '\uf127',
	                    size: 33
	                }
	            },
	            noticia: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf1ea',
	                    size: 33
	                }
	            },
	            fabrica: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf275',
	                    size: 33
	                }
	            },
	            telecomunicacion: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: "\uf20e",
	                    size: 33
	                }
	            },
	            empresa: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf1ad',
	                    size: 33
	                }
	            },
	            persona: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf2bd',
	                    size: 40
	                }
	            },
	            riesgo: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf25d',
	                    size: 50
	                }
	            },
	            medios: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome-old',
	                    code: '\uf0a1',
	                    size: 30
	                }
	            },
	            empty: {
	                shape: 'icon',
	                icon: {
	                    face: 'FontAwesome',
	                    code: '\uf07c',
	                    size: 30
	                }
	            }
	        }
	    };
	    var network = new vis.Network(container, data, options);
		}

	</script>
</body>
</html>
