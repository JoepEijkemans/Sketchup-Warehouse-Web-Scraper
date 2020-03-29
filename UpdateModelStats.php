<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>
<?php

Require_Once($_SERVER['DOCUMENT_ROOT'].'/config.php'); //external file with db config

$URLS = array();
$IDS = array();
	$sql = "SELECT * FROM (table name)";
	$mysqli = new mysqli($db_server, $db_user, $db_pass, $db_name);
	$result = $mysqli->query($sql);
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($URLS, $row['URL']);
			array_push($IDS, $row['ID']);
		}
	}
	

$table = array(array());

for ($i = 0; $i <= count($URLS) - 1; $i++) {
    //table['URL'][0] = $URLS[$i];
	
	//print_r($stats);
	$stats = array();
	
	$curl = curl_init();

	curl_setopt($curl, CURLOPT_REFERER, 'https://3dwarehouse.sketchup.com/');
	curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
	curl_setopt($curl, CURLOPT_URL, $URLS[$i]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_COOKIESESSION, true);
	curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie.txt");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	

	$result  = curl_exec($curl);
	$getInfo = curl_getinfo($curl);

	if ($result === false) {
		$output = "Error in sending";
		if (curl_error($curl)){
			$output .= "\n". curl_error($curl);
		}
		} 
		else if($getInfo['http_code'] != 777){
			$output = "No data returned. Error: " . $getInfo['http_code'];
			if (curl_error($curl)){
				$output .= "\n". curl_error($curl);
		}
	}
	
	preg_match_all('!<span class="likesCount">(?s).*\sLikes!',$result,$match);
	$stats['Likes'] = $match[0];
	
	preg_match_all('!<span class="downloadsCount">(?s).*\sDownloads!',$result,$match);
	$stats['Downloads'] = $match[0];

	preg_match_all('!<span class="viewsCount">(?s).*\sViews!',$result,$match);
	$stats['Views'] = $match[0];



	$likes = str_replace('<span class="likesCount">', "", $stats['Likes'][0]);
	$likes = trim(str_replace('Likes', "", $likes));
	
	$downloads = str_replace('<span class="downloadsCount">', "", $stats['Downloads'][0]);
	$downloads = trim(str_replace('Downloads', "", $downloads));
	
	$views = str_replace('<span class="viewsCount">', "", $stats['Views'][0]);
	$views = trim(str_replace('Views', "", $views));
	
	echo '<div class="container" id="container">';
		echo '<p type="text" name="URL" id="URL">'. $URLS[$i] .'</p>';
		echo '<p type="text" name="Likes" id="Likes">'. $likes .'</p>';
		echo '<p type="text" name="Views" id="Views">'. $views .'</p>';
		echo '<p type="text" name="Downloads" id="Downloads">'. $downloads .'</p></br>';
	echo '</div>';

	

	$table[$i][0] = $URLS[$i];
	$table[$i][1] = $likes;
	$table[$i][2] = $views;
	$table[$i][3] = $downloads;
	
	curl_close($curl);
}
$mysqli->close();

echo '<h2>Stats updated</h2>';
echo '</br><p>You should be redirected back to the 3D Modelling portfolio automatically. If not, <a href="" title="Go to 3D Modelling Portfolio">click here</a>. Or <a href="www.joepeijkemans.nl" title="Go back to the homepage">go back to homepage</a>';
?>



</body>

<script>

$(document).ready(function(){
	var x = 0;
	var y = $(".container").length;
	
	$(this).delay(1000).queue(function(e) {

		$(".container").each(function(){
			URLElement = document.getElementById("URL");
			if (URLElement) {
				var URL = URLElement.innerHTML; 
			}else{
				var URL = "undefined";
			}

			LikesElement = document.getElementById("Likes");
			if (LikesElement) {
				var Likes = LikesElement.innerHTML; 
			}else{
				var Likes = "undefined";
			}

			ViewsElement = document.getElementById("Views");
			if (ViewsElement) {
				var Views = ViewsElement.innerHTML; 
			}else{
				var Views = "undefined";
			}

			DownloadsElement = document.getElementById("Downloads");
			if (DownloadsElement) {
				var Downloads = DownloadsElement.innerHTML; 
			}else{
				var Downloads = "undefined";
			}
					
			//alert(URL);	
			//alert(Likes);
			//alert(Views);
			//alert(Downloads);
		
			$.ajax({
				type: 'POST',
				url: 'jsQuery.php',
				data: {URL: URL, Likes: Likes, Views: Views, Downloads, Downloads},
				success: function(data){
					if($.trim(data) === '1'){
						x+=1;
							if(x >= y){
								setTimeout(' window.location.href = "/Portfolio/Projects/3DModelling/"', 1000);
							}
					} 
				},
				error: function(data){
					alert('error');
				}
			});
			$("#container").remove();
		});
	});
	

});
</script>

<script>
function Redirect() {
  location.replace("https://joepeijkemans.nl/Portfolio/Projects/3DModelling/");
}

</script>