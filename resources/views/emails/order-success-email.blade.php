<html>
    <head>
        <style type='text/css'>
            <!--
                .style2 {
                font-size: 11px;
                font-weight: bold;
                text-decoration: none;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                color:#666666;
                
                }
                .style3 {
                text-decoration: none;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 11px;
                color:#666666;
                }
                -->
        </style>
    </head>
    <body>
        <?php use App\Product; ?>
        <table width='700' border='0' cellpadding='0' cellspacing='0'  style='border:#EFEFEF 5px solid; padding:5px;'>
            <tr>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td  align='left' valign='middle'><img height="40px" border='0' src="{{ asset('images/max-logo.png') }}" alt='logo' /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td height='70' align='right' valign='top'>
                    <table width='93%' border='0' align='right' cellpadding='3' cellspacing='0' >
                        <tr>
                            <td align='left' valign='top' class='style3'><span class='style2'>Date :</span> <?php echo date('d F Y',strtotime(date('Y-m-d'))); ?></td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>Hey {{ $orderdetails['user']['name'] }},</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>Thanks for choosing Maxx Response.</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'><strong>Your order has been placed with the following details:</strong></td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'><span class='style2'>Invoice No</span> : {{ $orderdetails['invoice_id'] }} </td>
                        </tr>
                        @if(!empty($orderdetails['coupon_code']))
                            <tr>
                                <td align='left' valign='top' class='style3'><span class='style2'>Coupon Code</span> : {{ $orderdetails['coupon_code'] }} </td>
                            </tr>
                        @endif
                        <tr>
                            <td align='left' valign='top' class='style3'><span class='style2'>Payment Method</span> : @if($orderdetails['payment_mode'] =="ccavenue")
                                CCAvenue
                            @else
                                {{ucwords($orderdetails['payment_mode'])}}
                            @endif </td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>
                                <table width='95%' border='0' align='left' cellpadding='3' cellspacing='1' bgcolor='ACA899'>
                                    <tr>
                                        <td width='20%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Package Name</td>
                                        <td width='20%' align='center' valign='top' class='style2' bgcolor='#cccccc'>List Size</td>
                                        <td width='20%' align='center' valign='top' class='style2 text-center' bgcolor='#cccccc'>Subscription</td>
                                        <td width='20%' align='center' valign='top' class='style2 text-center' bgcolor='#cccccc'>Total</td>
                                    </tr>
                                    <tr>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['package_name'] }}</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['list_size'] }}</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>@if($orderdetails['subscription'] ==1)
                                            1 month
                                        @else
                                        {{$orderdetails['subscription']}} {{$orderdetails['subscription_type']}}
                                        @endif</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['currency'] }}&nbsp;{{number_format($orderdetails['package_price'],2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Sub Total</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['currency'] }}&nbsp;{{number_format($orderdetails['package_price'],2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Prepaid Discount(-)</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['currency'] }} &nbsp;{{ number_format((float)$orderdetails['prepaid_discount'] , 2, '.', '' )}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Coupon Discount(-)</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $orderdetails['currency'] }} &nbsp;{{ number_format((float)$orderdetails['coupon_discount'] , 2, '.', '' )}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Grand Total</td>
                                        <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'><strong>{{ $orderdetails['currency'] }} &nbsp;{{number_format($orderdetails['grand_total'],2) }}</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%'>
                                    <tr>
                                        <td width='50%'>
                                            <table width='100%' border='0' align='left' cellpadding='3' cellspacing='0'>
                                                <tr class='shop'>
                                                    <td colspan='2' align='left' valign='middle' class='style3' ><span class='top_text1'><strong>Billing:</strong></span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderdetails['user']['name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderdetails['company_name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderdetails['address'] }},{{ $orderdetails['city'] }},{{ $orderdetails['state'] }}-{{ $orderdetails['zip'] }},{{ $orderdetails['country'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td align='left' valign='middle' class='top_text1'></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align='left' valign='top' class='style3'>
                                <table width='90%' border='0' align='left' cellpadding='3' cellspacing='0'>
                                    <tr>
                                        <td colspan='3' class='style3'>
                                            <p><strong>Contact us:</strong></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height='16' colspan='3' class='style3'>
                                            <p><a href='mailto: info@maxxresponse.com'> info@maxxresponse.com</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height='16' colspan='3' class='style3'>
                                            <p> 0172 461 0626</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height='16' colspan='3' class='style3'>
                                            <div align='left'>   
                                                Regards,<br/>
                                                Team Maxx Response!
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' class='style3'>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' class='style3'>Please keep this email for future reference.</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
