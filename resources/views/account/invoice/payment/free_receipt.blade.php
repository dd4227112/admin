@include('components.email_page_layout')<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">

            <div class="x_content">
                <div class="row">

                    <!-- CONTENT MAIL -->
                    <div class="col-sm-12 mail_view">



                        <div class="inbox-body">



                            <div class="view-mail">
                                <?php
                                $receipt_setting = \DB::table('receipt_settings')->first();
                                $template = $receipt_setting->template;
                                $file = 'invoices.receipt_templates.' . $template;
                                $free=1;
                             
                                if (isset($payment_info) && !empty($payment_info)) {
                                    ?>
                                    @include("{$file}")
                                <?php } ?>
                            </div>


                        </div>
                    </div>
                    <!-- /CONTENT MAIL -->
                </div>
            </div>
        </div>
    </div>
</div>
