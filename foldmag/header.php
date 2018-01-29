<!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<?php do_action( 'mp_inside_head_tag' ); ?>
<?php wp_head(); ?>
<?php do_action( 'mp_before_end_head_tag' ); ?>
</head>
<body <?php body_class(); ?> id="custom">
<?php do_action( 'mp_start_webpage_schema' ); ?>
<?php do_action( 'mp_before_wrapper_main' ); ?>
<div id="wrapper-main">
<?php do_action( 'mp_before_wrapper' ); ?>
<div id="wrapper-container">
<div id="wrapper" class="innerwrap">
<div id="wrapper-content">
<?php do_action( 'mp_inside_wrapper' ); ?>
<?php get_template_part('templates/home-feat-cat'); ?>