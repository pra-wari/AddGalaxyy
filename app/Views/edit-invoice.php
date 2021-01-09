<?php echo view('header');
$user_id = session()->get('id');
$plan_start_date = date("F d, Y", strtotime($invoice[0]['relationData'][0]['plan_start_date']));
$plan_end_date = date("F d, Y", strtotime($invoice[0]['relationData'][0]['plan_end_date']));
?>
<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
</style>
<div class="search-bar center-xs">
    <div class="container-fluid">
        <div class="bread-crumb center-xs">
        </div>
    </div>
</div>
<section class="pb-95" id="desktop-view">
    <div class="container-fluid">
        <div class="row">
            <?php echo view('admin-sidebar');?>
            <div class="col-md-9 col-sm-8" id="product-de">
                <div class="product-listing1">
                    <div class="row" id="filterResult1">
                        <div class="container1">
                            <div class="col-md-12">
                                <div class="invoice-box">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr class="top">
                                            <td colspan="2">
                                                <table>
                                                    <tr>
                                                        <td class="title">
                                                            <img src="<?php echo base_url('public/images/logo.png');?>"
                                                                style="width:100%; max-width:300px;">
                                                        </td>

                                                        <td>
                                                            Invoice #: 000<?php echo $invoice[0]['id'];?><br>
                                                            Created: <?php echo $plan_start_date;?><br>
                                                            Due: <?php echo $plan_end_date;?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr class="information">
                                            <td colspan="2">
                                                <table>
                                                    <tr>
                                                        <td>
                                                        <?php echo $extras['hotlinks'][8]['option_value'];?>
                                                        </td>

                                                        <td>
                                                            <?php echo $invoice[0]['user'][0]['firstname'];?>
                                                            <?php echo $invoice[0]['user'][0]['lastname'];?><br>
                                                            <?php echo $invoice[0]['user'][0]['email'];?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr class="heading">
                                            <td>
                                                Payment Status
                                            </td>

                                            <td>
                                                Transaction Id #
                                            </td>
                                        </tr>

                                        <tr class="details">
                                            <td>
                                                <?php echo $invoice[0]['transactions'][0]['transaction_status']=='success'?'Paid':'Failed';?>
                                            </td>

                                            <td>
                                                <?php echo $invoice[0]['transactions'][0]['transaction_id'];?>
                                            </td>
                                        </tr>

                                        <tr class="heading">
                                            <td>
                                                Item
                                            </td>

                                            <td>
                                                Price
                                            </td>
                                        </tr>

                                        <tr class="item">
                                            <td>
                                                <?php echo $invoice[0]['plans'][0]['plan_name'];?>
                                                (<?php echo $invoice[0]['plansmeta'][0]['plan_duration'];?>)
                                            </td>

                                            <td>
                                                <i class="fa fa-inr" aria-hidden="true"></i>
                                                <?php echo $invoice[0]['price'];?>
                                            </td>
                                        </tr>

                                        <tr class="total">
                                            <td></td>

                                            <td>
                                                Total: <i class="fa fa-inr" aria-hidden="true"></i>
                                                <?php echo $invoice[0]['price'];?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="d-flex flex-row-reverse bd-highlight">
                                    <a href="<?php echo base_url('PdfController/htmlToPDF/'.$invoice[0]['id']) ?>" class="btn btn-primary">
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right side gallery end -->
    </div>
</section>
<?php echo view('footer',$extras); ?>