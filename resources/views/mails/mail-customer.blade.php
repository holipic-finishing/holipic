<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<style>
		
		body {
			background-color: #f2faff;
			margin: 0px auto; 
			padding: 0px auto;
			width: 500px;
			min-width: 500px;
		}
		table {
			background-color:#f2faff;
		}
		.title-mail {
			margin-left: 40px !important;
			font-size:20px;
			font-weight: bold;
		}
		.content-email {
			margin-left: 40px !important;
			font-size:17px;
		}
	</style>
</head>
<body>
	@if(!isset($email) && !isset($password))
		<table cellpadding="0" cellspacing="0" style="width:100%">
		  <tr>
		   <td align="center" style="padding: 40px 0 30px 0;">
		     <img src="https://www.holipic.com/wp-content/uploads/2015/10/HOLIPIC-LOGO.png" alt="Creating Email Magic" width="30%" style="display: block;" />
		   </td>
		</tr>
		<tr style="padding: 0px 20px">
			<td>
		   		<span class="title-mail">{{$content['email_title']}}</span>
		   	</td>
		</tr>
		  
		<tr style="padding: 0px 20px">
	  		<td style="padding: 20px 0 30px 0;" >
	   			<span class="content-email">{{$content['format_email_content']}}</span>
	  		</td>
	 	</tr>
		  
	 	</table>
	@else
	<h3>Please login holipic with account</h3>
	<br>
	<span>Email: {{$email}}</span>
	<br>
	<span>Password: {{$password}}</span>
	@endif
	{{-- <div class="container">
		@if(isset($content)) 
			<div class="row">
				<div class="col-sm-12">
					{{$content['email_title']}}
				</div>
				<div class="col-sm-12">
					{{$content['email_content']}}
				</div>
				<span class="title-mail"> {{$content['email_title']}}</span>
			</div>
		
		@endif
	</div> --}}

</body>
</html>