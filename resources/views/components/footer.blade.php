{{-- <script type="text/javascript" src="<?= $root ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>  --}}
    <script type="text/javascript" src="<?= $root ?>files/bower_components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>files/bower_components/bootstrap/js/bootstrap.min.js"></script> 
        <!-- classie js -->
    <script type="text/javascript" src="<?= $root ?>bower_components/classie/classie.js"></script> 
      
        <!-- Custom js -->
    <script type="text/javascript" src="<?= $root ?>assets/js/script.js?v=3"></script>  
    
    <script type="text/javascript" src="<?= $root ?>files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="<?= $root ?>files/bower_components/modernizr/js/modernizr.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
       

    <script src="<?= $root ?>files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>files/assets/js/SmoothScroll.js"></script>
    <script src="<?= $root ?>files/assets/js/pcoded.min.js"></script>
    <script src="<?= $root ?>files/assets/js/vartical-layout.min.js"></script>

    <script type="text/javascript" src="<?= $root ?>files/assets/js/script.min.js"></script>

    <script type="text/javascript" src="<?= $root ?>files/bower_components/select2/js/select2.full.min.js"></script>

    {{-- Multiselect js --}}
    <script type="text/javascript" src="<?= $root ?>files/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="<?= $root ?>files/bower_components/multiselect/js/jquery.multi-select.js"></script>
  

    {{-- dtatables --}}
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/assets/pages/data-table/js/jszip.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/assets/pages/data-table/js/pdfmake.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/assets/pages/data-table/js/vfs_fonts.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/assets/pages/thousandth/thousands.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script  type="text/javascript"  src="<?= $root ?>files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    {{-- i18next.min.js --}}
    <script type="text/javascript" src="<?= $root ?>files/bower_components/i18next/js/i18next.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>bower_components/jquery-i18next/jquery-i18next.min.js"></script>

    <script src="<?= url('public') ?>/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>  
    <script type="text/javascript" src="<?= $root ?>assets/pages/dashboard/custom-dashboard.js?v=3"></script> 
      
 </body>
    <?php
    if (request('type_id') != 'subject' && !preg_match('/emailsms/', url()->current()) && !preg_match('/sales/', url()->current()) && !preg_match('/logs/', url()->current()) && !preg_match('/activity/', url()->current()) && !preg_match('/payment_history/i', url()->current()) && !preg_match('/api/', url()->current())) {
        ?>
          <script>
                @if(Session::has('success'))
                toastr.options =
                {
                   "closeButton" : true,
                   "progressBar" : true
                }
                toastr.success("{{ session('success') }}");
                @endif

                @if(Session::has('error'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.error("{{ session('error') }}");
                @endif

                @if(Session::has('info'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.info("{{ session('info') }}");
                @endif

                @if(Session::has('warning'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.warning("{{ session('warning') }}");
                @endif
            </script>

        <script type="text/javascript">
            //Prevent Tabs from displaying previous content
         $(document).ready(function () {
 				//Hide all Tabs on load
        $('.tab-pane').hide();
        
        //Check which tab is active
        var activeOnLoad = $('.card ul li a.active').attr("href");
        $(activeOnLoad).show();
        
        //Handle click event
        $('.card ul li a').on('click', function(e){
        	e.preventDefault();
          
          //Save clicked element to variable
          var clickedTab = $(this).attr("href");
          
          //Remove class from old tab
        	$(this).parents('ul').find('.active').removeClass('active');
          //Add Active class to clicked tab
        	$(this).addClass('active');
          //Hide all Tab elements
          $('.tab-pane').hide();
          
          //Show clicked Tab
          $(clickedTab).show();
        });
    });

                   
                        send_message = function (id) {
                            var to_user_id = $('#to_user_id' + id).val();
                            var body = $('#body').val();
                            $.ajax({
                                type: 'POST',
                                url: '<?= url('Users/storeChat/null') ?>',
                                data: {to_user_id: to_user_id, body: body},
                                dataType: "html",
                                success: function (data) {
                                    $('input[type="text"],textarea').val('');
                                    $('#usermessage').html(data);
                                }
                            });
                        }

                                    get_user = function (id) {
                                        var to_user_id = $('#to_user_id' + id).val();
                                        $.ajax({
                                            type: 'get',
                                            url: '<?= url('Users/getUser/null') ?>',
                                            data: {to_user_id: to_user_id},
                                            dataType: "html",
                                            success: function (data) {
                                                $('#usermessage').html(data);
                                            }
                                        });
                                    }

                                    $(document).ready(function () {
                                        $('.dataTable').DataTable({
                                            dom: 'Bfrtip',
                                            responsive: false,
                                            paging: true,
                                            info: false,
                                            "pageLength": 10,
                                            buttons: [
                                                {
                                                    text: 'PDF',
                                                    extend: 'pdfHtml5',
                                                    message: '',
                                                    orientation: 'landscape',
                                                    exportOptions: {
                                                        columns: ':visible'
                                                    },
                                                    customize: function (doc) {
                                                        doc.pageMargins = [10, 10, 10, 10];
                                                        doc.defaultStyle.fontSize = 7;
                                                        doc.styles.tableHeader.fontSize = 7;
                                                        doc.styles.title.fontSize = 9;
                                                        // Remove spaces around page title
                                                        doc.content[0].text = doc.content[0].text.trim();
                                                        // Create a footer
                                                        doc['footer'] = (function (page, pages) {
                                                            return {
                                                                columns: [
                                                                    'www.shulesoft.com',
                                                                    {
                                                                        // This is the right column
                                                                        alignment: 'right',
                                                                        text: ['page ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                                                    }
                                                                ],
                                                                margin: [10, 0]
                                                            }
                                                        });
                                                        // Styling the table: create style object
                                                        var objLayout = {};
                                                        // Horizontal line thickness
                                                        objLayout['hLineWidth'] = function (i) {
                                                            return .5;
                                                        };
                                                        // Vertikal line thickness
                                                        objLayout['vLineWidth'] = function (i) {
                                                            return .5;
                                                        };
                                                        // Horizontal line color
                                                        objLayout['hLineColor'] = function (i) {
                                                            return '#aaa';
                                                        };
                                                        // Vertical line color
                                                        objLayout['vLineColor'] = function (i) {
                                                            return '#aaa';
                                                        };
                                                        // Left padding of the cell
                                                        objLayout['paddingLeft'] = function (i) {
                                                            return 4;
                                                        };
                                                        // Right padding of the cell
                                                        objLayout['paddingRight'] = function (i) {
                                                            return 4;
                                                        };
                                                        // Inject the object in the document
                                                        doc.content[1].layout = objLayout;
                                                    }
                                                },

                                                {extend: 'excelHtml5', footer: true},
                                                {extend: 'csvHtml5', customize: function (csv) {
                                                        return "ShuleSoft" + csv + "ShuleSoft";
                                                    }},
                                                {extend: 'print', footer: true}

                                            ]
                                        });
                                    });

                                    $('form').each(function (i, form) {
                                        var $form = $(form);
                                        if (!$form.find('input[name="_token"]').length) {
                                            $('form').prepend('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').prop('content') + '"/>');
                                        }
                                    });

                                    // $('.clockpicker').clockpicker({
                                    //     donetext: 'Done'
                                    // }).find('input').change(function () {
                                    //     console.log(this.value);
                                    // });
                            </script>
                        <?php } ?>
                    </html>
                    <?php
///echo url()->current();
 if (preg_match('/localhost/', url()->current())) {?>
    <p align="center">This page took <?php echo (microtime(true) - LARAVEL_START) ?> seconds to render</p>
  <?php } ?> 

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            