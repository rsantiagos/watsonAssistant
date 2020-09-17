<div class="mapcontainer" width="600px" height="400px">
    <div class="map" style="display: none; overflow: hidden; width:600px; height:400px;">
        <span>Alternative content for the map</span>
    </div>
    <div class="areaLegend" style="position: relative; top: -28em; margin-left: 44em;"></div>
    <div class="plotLegend"></div>
</div>
<link href="assets/css/mapael/estilo_mapael.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/js/mapael/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/mapael/jquery.mousewheel.min.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/mapael/raphael.min.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/mapael/jquery.mapael.min.js" charset="utf-8"></script>
<script type="text/javascript" src="assets/js/mapael/mexico.js" charset="utf-8"></script>

<!--script id="mapaJSON" type="text/javascript">
    function cargaMapa(){
        $(".mapcontainer").mapael(
            {
                "map": {
                    "name": "mexico",
                    "zoom": {
                        "enabled": "true",
                        "maxLevel": 10
                    }
                },
                "legend": {
                    "area": {
                        "display": true,
                        "title": "REGIONES DE VENTA TELCEL",
                        "mode": "vertical",
                        "slices": [
                            {
                                "max": "1",
                                "min": "1",
                                "attrs": {
                                    "fill": "#CFB3B2"
                                },
                                "label": "R1 - BCN, BCS"
                            },
                            {
                                "max": "2",
                                "min": "2",
                                "attrs": {
                                    "fill": "#FDFFB1"
                                },
                                "label": "R2 - SIN, SON"
                            },
                            {
                                "max": "3",
                                "min": "3",
                                "attrs": {
                                    "fill": "#ACEFFF"
                                },
                                "label": "R3 - CHH, DUR"
                            },
                            {
                                "max": "4",
                                "min": "4",
                                "attrs": {
                                    "fill": "#83CD9A"
                                },
                                "label": "R4 - COA, NLE, TAM"
                            },
                            {
                                "max": "5",
                                "min": "5",
                                "attrs": {
                                    "fill": "#CB8CB7"
                                },
                                "label": "R5 - COL, HID, JAL, MIC, NAY"
                            },
                            {
                                "max": "6",
                                "min": "6",
                                "attrs": {
                                    "fill": "#96B8DE"
                                },
                                "label": "R6 - AGU, GUA, QUE, SLP, ZAC"
                            },
                            {
                                "max": "7",
                                "min": "7",
                                "attrs": {
                                    "fill": "#C5B0FE"
                                },
                                "label": "R7 - GRO, OAX, PUE, TLA, VER"
                            },
                            {
                                "max": "8",
                                "min": "8",
                                "attrs": {
                                    "fill": "#F6949C"
                                },
                                "label": "R8 - CAM, CHP, ROO, TAB, YUC"
                            },
                            {
                                "max": "9",
                                "min": "9",
                                "attrs": {
                                    "fill": "#01E751"
                                },
                                "label": "R9 - CMX, MEX, MOR"
                            }
                        ]
                    }
                },
                "areas": {
                    "BAJA CALIFORNIA NORTE": {
                        "value": "1",
                        "href": "#",
                        "tooltip": {
                            "content": "1 - BAJA CALIFORNIA NORTE"
                        }
                    },
                    "BAJA CALIFORNIA SUR": {
                        "value": "1",
                        "href": "#",
                        "tooltip": {
                            "content": "1 - BAJA CALIFORNIA SUR"
                        }
                    }
                }
            }
        )
    }
    cargaMapa();
</script-->

<!--script type="text/javascript">
    $(".mapcontainer").mapael(
        {
            "map": {
                "name": "mexico",
                "zoom": {
                    "enabled": "true",
                    "maxLevel": 10
                }
            },
            "legend": {
                "area": {
                    "display": true,
                    "title": "REGIONES DE VENTA TELCEL",
                    "mode": "vertical",
                    "slices": [
                        {
                            "max": "1",
                            "min": "1",
                            "attrs": {
                                "fill": "#CFB3B2"
                            },
                            "label": "R1 - BCN, BCS"
                        },
                        {
                            "max": "2",
                            "min": "2",
                            "attrs": {
                                "fill": "#FDFFB1"
                            },
                            "label": "R2 - SIN, SON"
                        },
                        {
                            "max": "3",
                            "min": "3",
                            "attrs": {
                                "fill": "#ACEFFF"
                            },
                            "label": "R3 - CHH, DUR"
                        },
                        {
                            "max": "4",
                            "min": "4",
                            "attrs": {
                                "fill": "#83CD9A"
                            },
                            "label": "R4 - COA, NLE, TAM"
                        },
                        {
                            "max": "5",
                            "min": "5",
                            "attrs": {
                                "fill": "#CB8CB7"
                            },
                            "label": "R5 - COL, HID, JAL, MIC, NAY"
                        },
                        {
                            "max": "6",
                            "min": "6",
                            "attrs": {
                                "fill": "#96B8DE"
                            },
                            "label": "R6 - AGU, GUA, QUE, SLP, ZAC"
                        },
                        {
                            "max": "7",
                            "min": "7",
                            "attrs": {
                                "fill": "#C5B0FE"
                            },
                            "label": "R7 - GRO, OAX, PUE, TLA, VER"
                        },
                        {
                            "max": "8",
                            "min": "8",
                            "attrs": {
                                "fill": "#F6949C"
                            },
                            "label": "R8 - CAM, CHP, ROO, TAB, YUC"
                        },
                        {
                            "max": "9",
                            "min": "9",
                            "attrs": {
                                "fill": "#01E751"
                            },
                            "label": "R9 - CMX, MEX, MOR"
                        }
                    ]
                }
            },
            "areas": {
                "BAJA CALIFORNIA NORTE": {
                    "value": "1",
                    "href": "#",
                    "tooltip": {
                        "content": "1 - BAJA CALIFORNIA NORTE"
                    }
                },
                "BAJA CALIFORNIA SUR": {
                    "value": "1",
                    "href": "#",
                    "tooltip": {
                        "content": "1 - BAJA CALIFORNIA SUR"
                    }
                }
            }
        }
    )
</script-->

<script id="hahaha" type="text/javascript">
    <?= $script  ?>
</script>
