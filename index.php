<?php
$base_url = 'localhost';
if ( ! isset($_REQUEST['iCloud']))
{
	if ( ! array_key_exists('activation-info', $_POST)) exit('Please connect your device to iTunes');

	$id = time();
	file_put_contents('data/' . $id . '.txt', serialize($_POST));
	$info = str_replace(array("\n", "\t"), "", $_POST['activation-info']);
	preg_match('#<key>ActivationInfoXML</key><data>(.+?)</data>#si', $info, $match);
	$info = str_replace(array("\n", "\t"), "", base64_decode($match[1]));

	preg_match('#<key>ActivationState</key><string>(.+?)</string>#si', $info, $match);
	$ActivationState = $match[1];
	preg_match('#<key>ProductType</key><string>(.+?)</string>#si', $info, $match);
	$ProductType = $match[1];
	preg_match('#<key>ProductVersion</key><string>(.+?)</string>#si', $info, $match);
	$ProductVersion = $match[1];

	echo '<style type="text/css">
	body{background-color:#eff0ef;border-top:1px solid #e9e9e9;padding:0;margin:0;font-family:Tahoma;color:#444;font-size:11px;}
	table {font-size:11px;font-family:Tahoma;margin-top:10px;}
	table tr td.x {font-weight:bold;}
	table tr td.y {color:#666;}
	</style>
	<div style="text-align:center;margin-top:50px;">
	Please Wait<br>
	<strong>iCloud bypass</strong>
	<br>Applying Transaction..<br>
	<img style="margin-top:10px;" src="http://' . $base_url . '/deviceservices/deviceActivation/spinner.gif">
		<table align="center">
	<td class="x">ActivationState:</td>
	<td class="y">' . $ActivationState . '</td>
	<td class="x">ProductType:</td>
	<td class="y">' . $ProductType . '<td>
	<td class="x">ProductVersion:</td>
	<td class="y">' . $ProductVersion . '</td>
	</table>
	<a href="http://www.twitter.com/WeAredoulCi" target="_blank" style="text-decoration:none;color:#115fbf;">@WeAredoulCi - #doulCiIsReady</a>
	
	</div>
		<script type="text/javascript">		
			setTimeout(function(){
				window.location.href = "http://' . $base_url . '/deviceservices/deviceActivation/?iCloud=' . $id . '";
			}, 2000);
		</script>
	';
	exit();
}
include 'serverCASigned.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="iTunes Store" />
<meta name="description" content="iTunes Store" />
<title>iPhone Activation</title>
<link href="http://static.ips.apple.com/ipa_itunes/stylesheets/shared/common-min.css" charset="utf-8" rel="stylesheet" />
<link href="http://static.ips.apple.com/deviceservices/stylesheets/styles.css" charset="utf-8" rel="stylesheet" />
<link href="http://static.ips.apple.com/ipa_itunes/stylesheets/pages/IPAJingleEndPointErrorPage-min.css" charset="utf-8" rel="stylesheet" />
<?php echo '<script id="protocol" type="text/x-apple-plist">'; ?>
<plist version="1.0">
  <dict>
	<key>iphone-activation</key>
	<dict>
	  <key>activation-record</key>
	  <dict>
		<key>FairPlayKeyData</key>
		<data><?php echo $FairPlayKeyData; ?></data>
		<key>AccountTokenCertificate</key>
		<data><?php echo $accountTokenCertificateBase64; ?></data>
		<key>DeviceCertificate</key>
		<data><?php $deviceCertificate; ?></data>
		<key>AccountTokenSignature</key>
		<data><?php echo $accountTokenSignature; ?></data>
		<key>AccountToken</key>
		<data><?php echo $accountTokenBase64; ?></data>
	  </dict>
	  <key>ack-received</key>
  <true/>
  <key>show-settings</key>
  <true/>
	</dict>
  </dict>
</plist>
<?php echo '</script>'; ?>
<script>
var protocolElement = document.getElementById("protocol");
var protocolContent = protocolElement.innerText;iTunes.addProtocol(protocolContent);
</script>
</head>
<body>
</body>
</html>