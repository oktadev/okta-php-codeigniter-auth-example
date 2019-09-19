<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="PHP Login App bd-index-custom-example">
        <title>Code Igniter + Okta Login Example </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    </head>
    <body class="layout-default">
        <nav id="navbar" class="navbar has-shadow is-spaced">
            <div class="container">
                <div class="content">
                <h1>Code Igniter + Okta Login Example</h1>
                <?php
                    if (isset($username)) {
                ?>
                        <p>
                            Logged in as <?php echo $username; ?>
                        </p>
                        <p>
                            <a href="<?php echo site_url('news/create'); ?>">New article</a>
                            | <a href="<?php echo site_url('logout'); ?>">Log Out</a>
                        </p>
                <?php
                    } else {
                ?>
                        <p>Not logged in</p>
                        <p><a href="<?php echo site_url('login'); ?>">Log In</a></p>
                <?php
                    }
                ?>