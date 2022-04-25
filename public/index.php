<?php

use App\Routeur;
require __DIR__ . '/../includes.php';

session_start();

Routeur::route();
