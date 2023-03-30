  <style>
   @page  
{ 
    size: auto;   /* auto is the initial value */ 

    /* this affects the margin in the printer settings */ 
    margin-top:  25mm;  
} 

body  
{ 
    /* this affects the margin on the content before sending to printer */ 
    margin: 0px;  
} 
</style>
    

                                <?php
                                $receipt_setting = \DB::table('receipt_settings')->first();
                                $template = $receipt_setting->template;
                                $file = 'invoices.bulk_receipt_templates.' . $template;
                                if (isset($payments) && !empty($payments)) {  ?>

                        
                                    @include("{$file}")
                                    
                                                 <?php } 