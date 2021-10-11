<?php

namespace Templex\Helper;


use Templex\Templex;
use Joomla\CMS\Factory;

class ConfigHelper
{
    public $parsedData = array();


    public function __construct()
    {
        $configFile = file_get_contents(__DIR__ . "/../Config/config.json");
        $this->parsedData = json_decode($configFile, true);
    }


    public function get($layout, $key = null)
    {

        if (Factory::getApplication()->getmenu()->getActive()->alias == 'searchhotel') {
            $activMenu = 'content-page';
        } else if (Factory::getApplication()->getmenu()->getActive()->alias == 'home') {
            $activMenu = 'front-page';
        } else {
            $activMenu = 'default';
        }
        // switch (Factory::getApplication()->getmenu()->getActive()->alias) {
        //     case 'searchhotel':
        //         echo 1;
        //         $activMenu = 'content-page';
        //     case 'home':
        //         $activMenu = 'front-page';
        // };


        if ($key !== null) {


            if (strpos($layout, '.') === false) :
                switch ($layout) {
                    case 'blocks':
                        return isset($this->parsedData['layouts'][$activMenu]['blocks']) ?  $this->parsedData['layouts'][$activMenu]['blocks'] : $key;
                    case 'body_config':
                        return isset($this->parsedData['totop_scroller']) ?  $this->parsedData['totop_scroller'] : $key;
                    case 'totop_scroller':
                        return isset($this->parsedData['totop_scroller']) ? $this->parsedData['totop_scroller'] : "0";
                    case 'warp_branding':
                        return isset($this->parsedData['warp_branding']) ? $this->parsedData['warp_branding'] : "0";
                    case 'system_output':
                        return (isset($this->parsedData['system_output']) ? $this->parsedData['system_output'] : ($key === true ? "1" : "0"));
                    case 'twitter':
                        return isset($this->parsedData['twitter']) ? $this->parsedData['twitter'] : "0";
                    case 'facebook':
                        return isset($this->parsedData['facebook']) ? $this->parsedData['facebook'] : "0";
                    case 'plusone':
                        return isset($this->parsedData['plusone']) ? $this->parsedData['plusone'] : "0";
                    case 'block_frame':
                        return isset($this->parsedData['block_frame']) ? $this->parsedData['block_frame'] : "0";
                    case 'navigation_style':
                        return  isset($this->parsedData['layouts'][$key][$layout]) ? $this->parsedData['layouts'][$key][$layout] : '';
                    case 'navigation_style':
                        return  isset($this->parsedData['layouts'][$key][$layout]) ? $this->parsedData['layouts'][$key][$layout] : '';
                    case 'grid':
                        return  isset($this->parsedData['layouts'][$activMenu][$layout]) ? $this->parsedData['layouts'][$activMenu][$layout] : array();
                    case 'sidebars':
                        return  isset($this->parsedData['layouts'][$activMenu]['sidebars']) ? $this->parsedData['layouts'][$activMenu]['sidebars'] : array();

                    default:
                        return isset($this->parsedData[$layout]) ? $this->parsedData[$layout] : "0";
                }
            else :

                $widgets = explode('.', $layout);
                switch ($widgets[0]) {
                    case 'widgets':
                        return  isset($this->parsedData['widgets'][$widgets[1]]) ? $this->parsedData['widgets'][$widgets[1]] : $key;
                    case 'blocks':
                        return isset($this->parsedData['layouts'][$activMenu]['blocks'][$widgets[1]][$widgets[2]]) ? $this->parsedData['layouts'][$activMenu]['blocks'][$widgets[1]][$widgets[2]] : $key;
                    case 'grid':
                        return  isset($this->parsedData['layouts'][$activMenu][$widgets[0]][$widgets[1]][$widgets[2]]) ? $this->parsedData['layouts'][$activMenu][$widgets[0]][$widgets[1]][$widgets[2]] : array();

                    default:
                        return array();
                }
            endif;
        } else {

            if (strpos($layout, '.') !== false) {
                $template = explode('.', $layout);

                switch ($template[0]) {
                    case 'grid':
                        if (isset($template[2])) :
                            return $template[0] == 'grid' ? $this->parsedData['layouts'][$activMenu][$template[0]][$template[1]][$template[2]] : '';
                        else :
                            return $template[0] == 'grid' ? $this->parsedData['layouts'][$activMenu][$template[0]][$template[1]] : '';
                        endif;
                    case 'blocks':
                        return isset($this->parsedData['layouts'][$activMenu]['blocks'][$template[1]][$template[2]]) ? $this->parsedData['layouts'][$activMenu]['blocks'][$template[1]][$template[2]] : $key;

                    default:
                        return '';
                }
            } else {
                switch ($layout) {
                    case 'sidebars':
                        return  isset($this->parsedData['layouts'][$activMenu]['sidebars']) ? $this->parsedData['layouts'][$activMenu]['sidebars'] : array();

                    case 'article':
                        return $this->parsedData['layouts'][$activMenu][$layout];
                    default:
                        return isset($this->parsedData[$layout]) ? $this->parsedData[$layout] : "0";
                }
            }
        }
    }
}
