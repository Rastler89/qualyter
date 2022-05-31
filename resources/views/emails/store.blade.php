<!-- Complete Email template -->
<head>
    <style>
        @font-face {
            font-family: Poppins;
            src: url({{asset('fonts/Poppins-Regular.ttf')}});
        }

    </style>
</head>
<body style="background-color:grey;font-family: Poppins;">
<table align="center" border="0" cellpadding="0" cellspacing="0"
width="550" bgcolor="white" style="border:2px solid black">
<tbody>
<tr>
<td align="center">
<table align="center" border="0" cellpadding="0"
cellspacing="0" class="col-550" width="550">
<tbody>
<tr>
<td align="center" style="border-bottom: 2px solid #0086ff;
height: 50px;">

<a href="#" style="text-decoration: none;">
<p style="color:white;
font-weight:bold;">
<img src="{{asset('img/logo_completo.png')}}" width="50%" />
</p>
</a>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr style="display: inline-block;">
<td style="height: 400px;
width:100vw;
padding: 20px;
border: none; 
background-color: white;
text-align: center;">
<p class="data"
style="text-align: justify-all;
align-items: center; 
font-size: 17px;
padding-bottom: 12px;">
<strong>{{__('Hello')}}, {{$body['client']}}</strong>
<br/>
<br/>
{{__("After in-store visit, we would like to know what you think of the service you received by answering this short reply.")}}
<br/>
{{__('many thanks for your time')}}
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
height: 40px; 
color:white; 
padding-bottom: 20px; 
text-align: center;">

<td height="40px" style="text-align:center;">
<p style="color:white; 
line-height: 1.5em;">
<img src="{{asset('img/logo_variacion3.png')}}" width="25%"/>
</p>
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
</td>
</tr>
</tbody>
</table>
</body>