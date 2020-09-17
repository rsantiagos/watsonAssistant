                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="public/bower_components/jquery/js/jquery.min.js" type="text/javascript"></script>
        <script src="public/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
        <script src="public/bower_components/popper.js/js/popper.min.js" type="text/javascript"></script>
        <script src="public/bower_components/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="public/bower_components/jquery-slimscroll/js/jquery.slimscroll.js" type="text/javascript"></script>
        <script src="public/bower_components/modernizr/js/modernizr.js" type="text/javascript"></script>
        <script src="public/bower_components/modernizr/js/css-scrollbars.js" type="text/javascript"></script>
        <script src="public/bower_components/moment/js/moment.min.js" type="text/javascript"></script>
        <script src="public/assets/pages/widget/calender/pignose.calendar.min.js" type="text/javascript"></script>
        <script src="public/bower_components/classie/js/classie.js" type="text/javascript"></script>
        <script src="public/bower_components/c3/js/c3.js"></script>
        <script src="public/assets/pages/chart/knob/jquery.knob.js"></script>
        <script src="public/assets/pages/widget/jquery.sparkline.js" type="text/javascript"></script>
        <script src="public/bower_components/d3/js/d3.js"></script>
        <script src="public/bower_components/rickshaw/js/rickshaw.js"></script>
        <script src="public/bower_components/raphael/js/raphael.min.js"></script>
        <script src="public/bower_components/morris.js/js/morris.js"></script>
        <script src="public/assets/pages/todo/todo.js" type="text/javascript"></script>
        <script src="public/assets/pages/chart/float/jquery.flot.js"></script>
        <script src="public/assets/pages/chart/float/jquery.flot.categories.js"></script>
        <script src="public/assets/pages/chart/float/jquery.flot.pie.js"></script>
        <script src="public/assets/pages/chart/echarts/js/echarts-all.js" type="text/javascript"></script>
        <script src="public/assets/pages/dashboard/horizontal-timeline/js/main.js" type="text/javascript"></script>
        <script src="public/assets/pages/dashboard/amchart/js/amcharts.js" type="text/javascript"></script>
        <script src="public/assets/pages/dashboard/amchart/js/serial.js" type="text/javascript"></script>
        <script src="public/assets/pages/dashboard/amchart/js/light.js" type="text/javascript"></script>
        <script src="public/assets/pages/dashboard/amchart/js/custom-amchart.js" type="text/javascript"></script>
        <script src="public/bower_components/i18next/js/i18next.min.js" type="text/javascript"></script>
        <script src="public/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js" type="text/javascript"></script>
        <script src="public/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js" type="text/javascript"></script>
        <script src="public/bower_components/jquery-i18next/js/jquery-i18next.min.js" type="text/javascript"></script>
        <!-- <script src="public/assets/pages/dashboard/custom-dashboard.js" type="text/javascript"></script> -->
        <script src="public/assets/js/script.js" type="text/javascript"></script>
        <script src="public/assets/js/pcoded.min.js"></script>
        <script src="public/assets/js/demo-12.js"></script>
        <script src="public/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="public/assets/js/jquery.mousewheel.min.js"></script>

        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.desktop.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.buttons.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.confirm.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.callbacks.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.animate.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.history.js"></script>
        <script type="text/javascript" src="public/bower_components/pnotify/js/pnotify.mobile.js"></script>

        <script type="text/javascript" src="public/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>

        <script src="public/assets/js/main.js"></script>
        <script src="public/assets/js/asistenteVoz.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                <?php
                if ($this->session->flashdata('notify')) {
                    if ($_SESSION['notify']['status'] == 0) { ?>
                        $("#input-login-email").val("<?= $_SESSION['data']['email'] ?>");
                        $("#input-login-password").val("<?= $_SESSION['data']['password'] ?>");
                        $("#sign-in").modal('show');
                        $(function(){
                            new PNotify({
                                title: 'Verifica',
                                text: "<?= $_SESSION['notify']['message'] ?>",
                                icon: 'icofont icofont-info-circle',
                                type: 'default'
                            })
                        });
                    <?php } elseif($_SESSION['notify']['status'] == 1) { ?>
                        console.log("notif yes");
                        $(function(){
                            new PNotify({
                                title: 'Hola',
                                text: "<?= $_SESSION['notify']['message'] ?>",
                                icon: 'icofont icofont-info-circle',
                                type: 'success'
                            })
                        });
                    <?php } elseif($_SESSION['notify']['status'] == 2) { ?>
                        console.log("notif yes");
                        $(function(){
                            new PNotify({
                                title: 'Adiós',
                                text: "<?= $_SESSION['notify']['message'] ?>",
                                icon: 'icofont icofont-info-circle',
                                type: 'default'
                            })
                        });
                    <?php }
                } else { ?>
                    console.log("no notif");
                <?php }?>
            });
        </script>
    </body>
</html>