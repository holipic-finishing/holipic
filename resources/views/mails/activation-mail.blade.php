<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
        <img src="{{ secure_asset('images/HOLIPIC-LOGO.png') }}">
	</div>
	<div> Hello <b>{{$fullname}} </b></div>
	<p>Click here to active your account</p>
    <p><a href="{{ $activation_link }}" target="_blank">{{ $activation_link }}</a></p>
    <p>Thank you</p>
    <p>From Holipic</p>
</body>
</html>
