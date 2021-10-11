<?php

namespace Templex\Helper;

use Joomla\CMS\Uri\Uri;
use Templex\Templex;
use ArrayObject;

class PathHelper
{

    public function path($ressource)
    {
        if (strpos($ressource, ':')) :
            return JPATH_SITE . '\templates\bwi_template_j4\layouts\\' . explode(':', $ressource)[1];
        else :
            return JPATH_SITE . '\templates\bwi_template_j4\layouts\\' .  $ressource;
        endif;
    }


    public function url($url)
    {
        if (strpos($url, ':')) :

            switch (explode($url, ':')[0]) {
                case 'site':
                    return URI::base(true) . '/';
                default:
                    return;
            }

        else :

        endif;
    }
}
