<?php

namespace Templex\Helper;


use Templex\Templex;
use ArrayObject;

class TemplateHelper extends ArrayObject
{
    protected $slots = array();

    public $templateData = array();
    public function __construct(Templex $Templex)
    {
        $this->templateData = $Templex->data;
        parent::__construct($this->templateData);
    }




    public function setWidgetsData($widgetsArr)
    {

        $this['widgets'] = $widgetsArr['widgets'];
        $this['template'] = $widgetsArr['template'];
        $this['config'] = $widgetsArr['config'];
        $this['path'] = $widgetsArr['path'];
        $this['system'] = $widgetsArr['system'];
    }





    public function render($resource, $args = array())
    {


        // echo '/';


        // if ($resource == 'widgets') {
        //     echo '<br />-----' . $args['position'] . '-----<br />';
        // } else {
        //     echo '<br /> ***' . $args['position'] . '***<br />';
        // }
        // default namespace
        if (strpos($resource, ':') === false) {
            $resource = 'layouts:' . $resource;
        }

        // trigger event
        //$this['event']->trigger('render.' . $resource, array(&$resource, &$args));

        // set resource and layout file
        $__resource = $resource;

        $__layout   = $this['path']->path($__resource . '.php');




        // render layout
        if ($__layout != false) {
            // print_r($__resource);
            // echo '||';
            // print_r($__layout);


            //echo '/';
            // import vars and get content

            //extract function return each key value as $variable = value; it is the opposite of compact
            // Input : array("a" => "one", "b" => "two", "c" => "three") // Output :$a = "one" , $b = "two" , $c = "three"
            extract($args);

            ob_start();
            include($__layout);
            return ob_get_clean();
        }


        trigger_error('<b>' . $__resource . '</b> not found in paths in layouts folder');

        return null;
    }

    /**
     * Slot exists ?
     * 
     * @param string $name
     * 
     * @return boolean      
     */
    public function has($name)
    {
        return isset($this->slots[$name]);
    }

    /**
     * Retrieve a slot.
     * 
     * @param string $name   
     * @param mixed  $default
     * 
     * @return mixed          
     */
    public function get($name, $default = false)
    {


        return isset($this->slots[$name]) ? $this->slots[$name] : $default;
    }

    /**
     * Set a slot.
     * 
     * @param string $name   
     * @param string $content
     */
    public function set($name, $content)
    {
        $this->slots[$name] = $content;
    }

    /**
     * Outputs slot content.
     * 
     * @param string $name   
     * @param mixed  $default
     * 
     * @return boolean
     */
    public function output($name, $default = false)
    {
        if (!isset($this->slots[$name])) {

            if (false !== $default) {
                echo $default;
                return true;
            }

            return false;
        }

        echo $this->slots[$name];
        return true;
    }
}
