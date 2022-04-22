<!-- Complete Email template -->

<body style="background-color:grey">
<table align="center" border="0" cellpadding="0" cellspacing="0"
width="550" bgcolor="white" style="border:2px solid black">
<tbody>
<tr>
<td align="center">
<table align="center" border="0" cellpadding="0"
cellspacing="0" class="col-550" width="550">
<tbody>
<tr>
<td align="center" style="background-color: #3417ff;
height: 50px;">

<a href="#" style="text-decoration: none;">
<p style="color:white;
font-weight:bold;">
Optima Retail
</p>
</a>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 200px;">
<td align="center" style="border: none;
border-bottom: 2px solid #0086ff; 
padding-right: 20px;padding-left:20px">

<p style="font-weight: bolder;font-size: 42px;
letter-spacing: 0.025em;
color:black;">
Hello {{$body['client']}}!
</p>
</td>
</tr>

<tr style="display: inline-block;">
<td style="height: 150px;
width:100vw;
padding: 20px;
border: none; 
border-bottom: 2px solid #0086ff;
background-color: white;
text-align: center;">
<p class="data"
style="text-align: justify-all;
align-items: center; 
font-size: 15px;
padding-bottom: 12px;">
{{_('Today your maintenance service has come to your store:')}}
<br>
{{$body['store']}}
</p>
<p>
<a href=
"{{Request::getHost()}}/store/survey/{{$body['id']}}?code={{$body['token']}}"
style="text-decoration: none; 
color:black; 
border: 2px solid #0086ff; 
padding: 10px 30px;
font-weight: bold;"> 
{{__('Reply to survey')}}               
</a>
</p>
</td>
</tr>
<tr style="border: none; 
background-color: #3417ff; 
height: 40px; 
color:white; 
padding-bottom: 20px; 
text-align: center;">

<td height="40px" style="text-align:center;">
<p style="color:white; 
line-height: 1.5em;">
Optima Retail
</p>


<a href="https://www.linkedin.com/company/optima-retail/"
style="border:none;
text-decoration: none; 
padding: 5px;"> 

<img height="30" 
src=
"https://extraaedgeresources.blob.core.windows.net/demo/salesdemo/EmailAttachments/icon-linkedin_20190610074015.png" 
width="30" /> 
</a>
</td>
</tr>
<tr>
<td style="font-family:'Open Sans', Arial, sans-serif;
font-size:11px; line-height:18px; 
color:#999999;" 
valign="top"
align="center">
© 2021 Optima Retail. {{__('All Rights Reserved')}}.<br>
</td>
</tr>
</tbody></table></td>
</tr>
<tr>
<td class="em_hide"
style="line-height:1px;
min-width:700px;
background-color:#ffffff;">
<img alt="" 
src="images/spacer.gif" 
style="max-height:1px; 
min-height:1px; 
display:block; 
width:700px; 
min-width:700px;" 
width="700"
border="0" 
height="1">
</td>
</tr>
</tbody>
</table>
</body>