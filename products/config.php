<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'auctionhouse';

$con = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}
