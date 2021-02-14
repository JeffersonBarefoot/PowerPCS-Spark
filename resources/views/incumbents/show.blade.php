@extends('navbarincumbents')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>

  </style>

</head>

<!-- set this to readonly to make this a show screen, or something else (blank, notreadonly, etc) to allow editing -->
<!-- note that for UNCHECKED radio buttons you have to use [disabled] instead of [readonly].  CHECKED radio buttons remain active-->
<?php $readonly=Session::get('readOnlyText') ?>
<?php $disabled=Session::get('disabledText') ?>
<?php $expandPositionHistory=Session::get('ExpandPositionHistory') ?>
<?php $expandIncumbentHistory=Session::get('ExpandIncumbentHistory') ?>


<body>
  Incumbent.Show.Blade.Php
</body>


@endsection
