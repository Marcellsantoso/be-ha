<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type"
	      content="text/html; charset=utf-8" />
	<meta name="viewport"
	      content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<? global $template; ?>
	<title><?= $template->title ?></title>
	<meta name="description"
	      content="<?= $template->metades ?>">
	<meta name="keywords"
	      content="<?= $template->metakey ?>">

	<!-- Google fonts -->
<!--	<link href='http://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic'-->
<!--	      rel='stylesheet'-->
<!--	      type='text/css'>-->
<!--	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400'-->
<!--	      rel='stylesheet'-->
<!--	      type='text/css'>-->
<!--	<link href='http://fonts.googleapis.com/css?family=Titillium+Web'-->
<!--	      rel='stylesheet'-->
<!--	      type='text/css'>-->

	<!-- font awesome -->
<!--	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"-->
<!--	      rel="stylesheet">-->
	<link href="<?= _SPPATH . _THEMEPATH; ?>/assets/font-awesome/css/font-awesome.min.css"
	      rel="stylesheet">

	<!-- bootstrap -->
	<link rel="stylesheet"
	      href="<?= _SPPATH . _THEMEPATH; ?>/assets/bootstrap/css/bootstrap.min.css" />

	<!-- uniform -->
	<link type="text/css"
	      rel="stylesheet"
	      href="<?= _SPPATH . _THEMEPATH; ?>/assets/uniform/css/uniform.default.min.css" />

	<!-- animate.css -->
	<link rel="stylesheet"
	      href="<?= _SPPATH . _THEMEPATH; ?>/assets/wow/animate.css" />

	<!-- favico -->
	<link rel="shortcut icon"
	      href="<?= _SPPATH ?>images/favicon.ico"
	      type="image/x-icon">
	<link rel="icon"
	      href="<?= _SPPATH ?>images/favicon.ico"
	      type="image/x-icon">

	<link rel="stylesheet"
	      href="<?= _SPPATH . _THEMEPATH; ?>/assets/style_green.css">

	<link href="<?= _SPPATH . _THEMEPATH ?>/assets/tx3-tag-cloud.css"
	      media="screen"
	      rel="stylesheet"
	      type="text/css">

<!--	<script type="text/javascript"-->
<!--	        src="http://code.jquery.com/jquery-1.10.0.min.js"></script>-->
</head>

<body>

<!-- header -->
<nav class="container navbar  navbar-inverse navbar-fixed-top"
     role="navigation">
	<div class="clearfix">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header"
		     style="height: 75px;">
			<button type="button"
			        class="navbar-toggle collapsed"
			        data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand"
			   href="<?= _SPPATH; ?>"><img src="<?= _SPPATH ?>images/logo.png"
			                               alt="logo">

				<h1 class="hide">Aqua Fashion leading brand of london and paris</h1></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-right"
		     id="bs-example-navbar-collapse-1">

			<form class="navbar-form navbar-left searchbar"
			      action="<?= _SPPATH ?>index"
			      method="get"
			      role="search">
				<div class="form-group">
					<input type="text"
					       class="form-control"
					       placeholder="<?= Lang::t('Search for products'); ?>"
					       name="search">
				</div>
				<button type="submit"
				        class="btn btn-inverse"><?= Lang::t('Search'); ?>
				</button>
			</form>
<!--			<a href="--><?//= _SPPATH . 'order' ?><!--"-->
<!--			   class="pull-right"-->
<!--			   style="margin-top: 15px"-->
<!--				><span class="glyphicon glyphicon-shopping-cart"></span>--><?//= Lang::t('Shopping Cart'); ?>
<!--			</a>-->
		</div>
		<!-- Wnavbar-collapse -->
	</div>
	<!-- container-fluid -->
</nav>

<!-- header -->

