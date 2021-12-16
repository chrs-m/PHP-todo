<?php

require __DIR__ . '/app/autoload.php';
unset($_SESSION['user']);
session_destroy();
redirect("/");
