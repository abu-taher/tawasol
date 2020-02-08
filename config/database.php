<?php

$mysqli = new mysqli("localhost", "root", "root", "tawasol");

if ($mysqli->connect_error) {
  die("Error connecting to database " . $mysqli->connect_error);
}