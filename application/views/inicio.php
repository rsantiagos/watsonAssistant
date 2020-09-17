<div id="resMapa"></div>
<div id="resGrafica"></div>
<div id="visjs"></div>
<?php
//$this->load->view('mapa_mex/index');
//$this->load->view('chart');
//$this->load->view('link_contenedor/index');
?>
<script type="text/javascript">
    function mostrarMapa()
    {

       $('#map').show(3000);
       $('.map').show("slow");
    }

    function ocultarMapa()
    {

       $('#map').hide(3000);
       $('.map').hide("fast");
    }
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
  //mostrarGrafica();
</script>
