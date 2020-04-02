<?php
  include 'db.php';
  session_start();
  include 'includes/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <title>TrekTrek</title>
  <style media="screen">

  span.text-color:after {
    content: '';
    width: 0px;
    height: 1px;
    display: block;
    background: linear-gradient(to right, #f12711, #f5af19);
    transition: 300ms;
  }

  span.text-color:hover:after {
    width: 90%;
    margin-left: 70px;
  }

  </style>
</head>
<body  style="font-family: Open Sans;">
