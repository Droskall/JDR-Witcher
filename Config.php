<?php

namespace App;

class Config
{
    // data base
    public const HOST = "localhost";
    public const DB_NAME = "witcher_jdr";
    public const USER = "root";
    public const PASSWORD = "";

    // send mail
    public const APP_URL = 'http://localhost:8000';

    //sticker list
    public const STICKER_TYPE = [
        'epic',
        'success',
        'fail',
        'dead',
        'heart',
    ];

    // link type list
    public const LINK_TYPE = [
        'discord',
        'useful',
        'video',
        'notice',
    ];

    // avatar list
    public const AVATAR_LIST = [
        'wolf_school.png',
        'viper_school.png',
        'cat_school.png',
        'bear_school.png',
        'griffin_school.png',
        'Jaskier.jpg',
        'eredin.jpg',
        'ciri.jpg',
        'Geralt-sombre.jpg',
        'triss.jpg',
        'vesemir.jpg',
        'Yenn.jpg'
    ];
}