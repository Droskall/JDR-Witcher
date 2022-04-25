<?php

namespace App;

class Color
{
    /**
     * change the color theme following the page
     * @param string $page
     * @return string
     */
    public static function getColor(string $page): string {
        switch ($page) {
            case 'home':
                $color = '#e09700';
                break;
            case 'help':
                $color = '#07819c';
                break;
            case 'resource':
                $color = '#d54398';
                break;
            case 'utils':
                $color = '#db3a3a';
                break;
            case 'utile':
                $color = '#e3e34c';
                break;
            case 'profile':
                $color = '#d2afaf';
                break;
        }

        return $color;
    }
}