<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title ?></title>

  <!-- BEGIN META -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- END META -->
  <link rel="shorcut icon" href="<?= base_url() . 'assets/img/logo.png' ?>">
  <!-- BEGIN STYLESHEETS -->
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/style-material.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/bootstrap.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/materialadmin.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/font-awesome/css/font-awesome.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/material-design-iconic-font.min.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/rickshaw.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/morris.core.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/style-material.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/DataTables/jquery.dataTables.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url() . 'assets/css/bootstrap-datepicker.css' ?>" />
  <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/bootstrap-select.css'); ?>">
  <link type="text/css" rel="stylesheet"
    href="<?= base_url() . 'assets/css/DataTables/extensions/dataTables.colVis.css' ?>" />
  <link type="text/css" rel="stylesheet"
    href="<?= base_url() . 'assets/css/DataTables/extensions/dataTables.tableTools.css' ?>" />

  <?php
  function limit_words($string, $word_limit)
  {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
  }
  ?>

</head>