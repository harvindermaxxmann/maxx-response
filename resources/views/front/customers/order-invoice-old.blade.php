<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
    <title>View Order Invoice</title>
</head>
<body>
    <div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="{{url('/')}}">
                            <img src="{{asset('images/maxman-logo.png')}}" data-holder-rendered="true" />
                            </a>
                    </div>
                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="{{url('/')}}">
                            Maxx Response
                            </a>
                        </h2>
                        <div>SCO 341-342 Sector 34A Near Helix Institute, Chandigarh, 160022</div>
                        <div>0172 461 0626</div>
                        <div>contactus@maxxmann.com</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to">{{Auth::user()->name}}</h2>
                        <div class="address">{{$orderDetails['address']}}</div>
                        <div class="email">{{Auth::user()->email}}</div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">{{$orderDetails['invoice_id']}}</h1>
                        <div class="date">Date of Invoice: {{date('d F Y',strtotime($orderDetails['created_at']))}}</div>
                        <div class="date">Due Date: {{date('d F Y',strtotime($orderDetails['expiry_date']))}}</div>
                        <div class="date">Payment Mode: {{$orderDetails['payment_mode']}}</div>
                        <div class="date">Payment Status: {{$orderDetails['payment_status']}}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th class="text-left">Package Name</th>
                            <th class="text-right">List Size</th>
                            <th class="text-right">Subscription Months</th>
                            <th class="text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no">{{$orderDetails['company_name']}}</td>
                            <td class="text-left"><h3>
                                {{$orderDetails['package_name']}}
                            </td>
                            <td class="unit">{{$orderDetails['list_size']}}</td>
                            <td class="qty">{{$orderDetails['subscription']}} {{$orderDetails['subscription_type']}}</td>
                            <td class="total">{{$orderDetails['currency']}} {{number_format($orderDetails['package_price'],2)}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>{{$orderDetails['currency']}} {{number_format($orderDetails['package_price'],2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Prepaid Discount (-)</td>
                            <td>{{$orderDetails['currency']}} {{number_format($orderDetails['prepaid_discount'],2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">Coupon Discount (-)</td>
                            <td>{{$orderDetails['currency']}} {{number_format($orderDetails['coupon_discount'],2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>{{$orderDetails['currency']}} {{number_format($orderDetails['grand_total'],2)}}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">Invoice was created on a computer and is valid without the signature and seal.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
</body>
</html>

<style type="text/css">
    #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
<<script type="text/javascript">
 $('#printInvoice').click(function(){
        Popup($('.invoice')[0].outerHTML);
        function Popup(data) 
        {
            window.print();
            return true;
        }
    });
</script>