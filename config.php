<?php

$conn = mysqli_connect("localhost", "root", "", "sample_db");

if (!$conn) {
    echo "Connection Failed";
}