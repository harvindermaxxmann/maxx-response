<html>
    <head>
        <style type='text/css'>
                .style1 {
                    color: #FFFFFF
                }
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
        </style>
    </head>
    <body>
        <table width='80%' border='0' cellpadding='3' cellspacing='3' style='border:#EFEFEF 5px solid; padding:5px;'>
            <tr>
                <td colspan='3'></td>
            </tr>
            <tr>
                <td align='left' valign='middle'><img border='0' height="30" src="{{ asset('images/max-logo.png') }}" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class='style2'>Hi! Your Sender Id has been approved successfully:-</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align='left' valign='top' class='style2'>Thank you for choosing Maxxreponse. Please find your Sender Id details below:- </a></td>
            </tr>           
            <tr>
               <td align='left' valign='middle'>
                   <table width='98%' border='0' align='right' cellpadding='5' cellspacing='5' style='background-color:#F5F5F5'>
                        <tr>
                           <td width='30%' align='left' valign='top' class='style2'>Sender Id</td>
                           <td width='5%' align='left' valign='top' class='style2'>:</td>
                           <td width='65%' align='left' valign='top' class='style3'>{{ $senderdetails->sender_id }}</td>
                        </tr>
                        <tr>
                           <td width='30%' align='left' valign='top' class='style2'>Description</td>
                           <td width='5%' align='left' valign='top' class='style2'>:</td>
                           <td width='65%' align='left' valign='top' class='style3'>{{ $data['description'] }}</td>
                        </tr>
                   </table>
               </td>
           </tr>
           <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td  class='style2'> Regards<br />
                    Team Maxx Response!!
                </td>
            </tr>
        </table>
    </body>
</html>
