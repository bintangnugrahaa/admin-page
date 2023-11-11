<?php
$koneksi = mysql_connect("localhost", "root", "root");
 if(!$koneksi)
 {
	 echo "Koneksi Gagal";
 }
 else
 {
	 mysql_select_db('toko');
 }
?>
