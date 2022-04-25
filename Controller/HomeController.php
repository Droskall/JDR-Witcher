<?php

namespace App\Controller;

use App\Color;

class HomeController extends AbstractController
{
    public function default()
    {
        self::render('home', null, $color = Color::getColor('home'));
    }
}
