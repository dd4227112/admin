<?php $root = url('/') . '/public/';
$bn_number = 888999;
?>
<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title> Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
  
  @media screen {
    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 400;
    }

    @font-face {
      font-family: 'Source Sans Pro';
      font-style: normal;
      font-weight: 700;
    }
  }

 
  body,
  table,
  td,
  a {
    -ms-text-size-adjust: 100%; /* 1 */
    -webkit-text-size-adjust: 100%; /* 2 */
  }

  table,
  td {
    mso-table-rspace: 0pt;
    mso-table-lspace: 0pt;
  }

  img {
    -ms-interpolation-mode: bicubic;
  }

  a[x-apple-data-detectors] {
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
    text-decoration: none !important;
  }


  div[style*="margin: 16px 0;"] {
    margin: 0 !important;
  }

  body {
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }

  table {
    border-collapse: collapse !important;
  }

  a {
    color: #1a82e2;
  }

  img {
    height: auto;
    line-height: 100%;
    text-decoration: none;
    border: 0;
    outline: none;
  }
  </style>

</head>
<body style="background-color: #D2C7BA;">


  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" bgcolor="#D2C7BA">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 800px;">
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                <h4> Payment Dates</h4>
                <hr/>
                <?php
                $all_payments = $invoice->payments()->first();
                if (isset($all_payments) ) { ?>
                <b  href="<?= url('account/receipts/' . $invoice->id . '/' . $all_payments->id) ?>">   
                           <div>
                                 Payer: 
                                <?= isset($all_payments->client->name) ? $all_payments->client->name:'' ?>
                              </div>
                             <div class="right">
                                 <span>Bank:  <?= $all_payments->bankAccount->account_name  ?></span><br/>
                                <span>Date:  <?= date('d M Y ', strtotime($all_payments->date)) ?></span>
                            </div> 
                        </b>
                     <hr/>
                <?php } ?>
            </td>
            <td align="right" bgcolor="#ffffff">
                <div style="z-index: ">
                    <img src="<?= url('public/images/company_seal.png') ?>"
                         width="200" height="150"
                         style="position:; margin-left: 3px; float:right;">
                </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#D2C7BA">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <?php
            $i = 0;
            if ((int) request()->segment(4) > 0) {
                $revenue = $invoice->payments()->where('id', request()->segment(4))->first();
            } else {
                $revenue = $invoice->payments()->first();
            }
            ?>
            <?php if (isset($revenue) && !empty($revenue)) { ?>
          <tr>
            <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 16px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                 <tr>
                    <div class="ttl-amts">
                      Receipt No
                        <span style="padding-left:100px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                            <?= isset($revenue->id) ?$revenue->id:''  ?></span><hr/>
                    </div>
                 </tr>
                <tr>
                    <div class="ttl-amts">
                        Date
                          <span style="padding-left:100px;padding-right: 130px; font-weight:bold; text-transform:uppercase">
                            <?= date('d M Y ', strtotime($revenue->date)) ?></span><hr/>
                      </div>
                </tr>
                <tr>
                    <div class="ttl-amts">
                        Received from
                        <span style="padding-left:100px;padding-right: 30px; font-weight:bold; text-transform:uppercase">
                            <?= isset($revenue->client->name) ?$revenue->client->name:''  ?></span><hr/>
                    </div>
                </tr>
                <tr>
                    <div class="ttl-amts">
                        Being Payment for
                        <span style="padding-left:76px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                            <?php
                            echo!empty($revenue->invoiceFees()->first()) ?
                                    $revenue->invoiceFees()->first()->item_name : 'Service Fee';
                            ?>
                        </span> <hr />
                    </div>
                </tr>
                <tr>
                    <div class="ttl-amts">
                        By cash/cheque No
                        <span style="padding-left:65px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                            <?= $revenue->transaction_id . '-' . $revenue->method; ?> </span> <hr/>
                    </div>
                </tr>
                <tr>
                  <td align="left" width="" style="font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif;">
                    Tshs: <b><?= money($revenue->amount) ?>/- </i></b>
                    <span style="padding-left:75px; font-weight:bold;padding-right: 50px; text-transform:uppercase">
                        NON.REFUNDABLE </span> <hr/>
                </td>
                </tr>
                <tr>
                    <div class="ttl-amts">
                        Amount in words

                        <span style="padding-left:85px;padding-right: 50px; font-weight:bold; text-transform:uppercase">
                            <?php
                            $amount = money($revenue->amount);
                            $am = (double) str_replace(',', NULL, $amount);
                            echo number_to_words($am);
                            ?>   ONLY</span><hr/>
                    </div>
                </tr>
              </table>
            </td>
          </tr>
        <?php } ?>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" bgcolor="#D2C7BA" valign="top" width="100%">
        <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
          <tr>
            <td align="center" valign="top" style="font-size: 0; border-bottom: 3px solid #d4dadf">
     
              <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                  <tr>
                    <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                    <img src="{{url('public/assets/images/inets.png')}}" height="100" alt="INETS Company Limtied, ShuleSoft School Management System">
                    </td>
                  </tr>
                </table>
              </div>
              <div style="display: inline-block; width: 100%; max-width: 50%; min-width: 240px; vertical-align: top;">
                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 300px;">
                  <tr>
                    <td align="left" valign="top" style="padding-bottom: 36px; padding-left: 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                      <p><strong>INETS COMPANY LIMITED</strong></p>
                      <p>
                        <b>TIN 122-866-750</b> 
                        <b>p.o Box 33287 Dar es Salaam  </b> 
                        <b>2nd Floor,Block NO. 576</b> 
                        <b>Mbezi Beach Bagamoyo Road</b> 
                        <b>Mobile no: +255 655 406 004 </b> 
                        <b>Telephone: +255 22 278 0228</b>
                      </p>
                    </td>
                  </tr>
                </table>
              </div>
          
            </td>
          </tr>
        </table>
      
      </td>
    </tr>

  </table>
  <!-- end body -->

</body>
</html>





<script src="{{url('public/assets/shulesoft/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">
function printDiv(divID) {
//Get the HTML of div
    var divElements = document.getElementById(divID).innerHTML;
//Get the HTML of whole page
    var oldPage = document.body.innerHTML;

//Reset the page's HTML with div's HTML only
    document.body.innerHTML =
            "<html><head><title></title></head><body><div style='margin-left: 4em; margin-right:4em; margin-top:10em'>" +
            divElements + "</div></body>";

//Print Page
    window.print();

//Restore orignal HTML
    document.body.innerHTML = oldPage;
}

$(document).ready(function () {
    $("#printInvoice").click(function () {

        printDiv("print_div");
    });
});
</script>
