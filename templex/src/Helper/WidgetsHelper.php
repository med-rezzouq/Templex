<?php

namespace Templex\Helper;


use Templex\Templex;
use ArrayObject;

class WidgetsHelper extends ArrayObject
{

    public $document;

    /**
     * Module renderer.
     * @var object
     */
    public $renderer;

    /**
     * @var array
     */
    protected $loaded;


    public function __construct(Templex $Templex)
    {
        $this->document = \JFactory::getDocument();
        $this->renderer = $this->document->loadRenderer('module');

        parent::__construct(array('widgetsHelper' => ''));
    }



    public function setTemplateData($templateArr)
    {
        $this['template'] = $templateArr['template'];
        $this['widgets'] = $templateArr['widgets'];
        $this['config'] = $templateArr['config'];
        $this['path'] = $templateArr['path'];
        $this['system'] = $templateArr['system'];
    }


    public function cnt($position)
    {
        // if ($this->document->countModules($position) != '0') {
        //     print_r($this->document->countModules($position));
        //     die;
        // }
        return $this->document->countModule($position);
    }

    /**
     * Shortcut to render a position
     *
     * @param  string $position
     * @param  array  $args
     * @return string
     */
    public function render($position, $args = array())
    {

        // set position in arguments
        $args['position'] = $position;
        // print_r($position);
        // print_r($args);
        // print_r($position);

        //echo '-';


        //cette fonction appelle la fonction render qui se trouve dans le fichier TemplateHelper.php
        return $this['template']->render('widgets', $args);
    }

    /**
     * Retrieve module objects for a position
     *
     * @param  string $position
     * @return array
     */
    public function load($position)
    {
        //this condition to check if this module already been loaded
        if (!isset($this->loaded[$position])) {
            // init vars
            $modules = \JModuleHelper::getModules($position);
            // set params, force no style
            $params = array('style' => 'none');

            // get modules content
            //and adding mor details of every module in this position as content and parameters and menu
            foreach ($modules as $module) {
                $module->parameter = new \JRegistry($module->params);
                $module->menu = $module->module == 'mod_menu';

                $module->content = $this->renderer->render($module, $params);
            }

            $this->loaded[$position] = $modules;
        }

        return $this->loaded[$position];
    }

    /**
     * Retrieve module objects for given positions.
     *
     * @param string[] $positions The positions to load modules for
     * @param int $clientId The clientId to filter for
     *
     * @return  array
     */
    public function loadForPositions(array $positions = array(), $clientId = 0)
    {
        if (empty($positions)) {
            return array();
        }

        $db = \JFactory::getDbo();

        // set query
        $db->setQuery($db->getQuery(true)
            ->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params')
            ->from('#__modules AS m')
            ->where('m.position IN (' . implode(',', array_map(function ($position) use ($db) {
                return $db->quote($position);
            }, $positions)) . ')')
            ->where('m.client_id = ' . $clientId)
            ->where('m.published <> -2')
            ->order('m.position, m.ordering'));

        try {
            $modules = $db->loadObjectList();
        } catch (\RuntimeException $e) {
            \JLog::add(\JText::sprintf('JLIB_APPLICATION_ERROR_MODULE_LOAD', $e->getMessage()), \JLog::WARNING, 'jerror');
            $modules = array();
        }

        return $modules;
    }

    /**
     * Get widgets grouped by position.
     *
     * @return array
     */
    public function getWidgets()
    {
        $return = array();

        if (!$tmpl_xml = $this['dom']->create($this['path']->path('theme:templateDetails.xml'), 'xml')) {
            return $return;
        }

        // get position settings
        $position_settings = array();

        foreach ($tmpl_xml->find('positions > position') as $position) {
            $position_settings[$position->text()] = $position;
        }

        $modules = $this->loadForPositions(array_keys($position_settings));

        foreach ($position_settings as $name => $position) {
            if ($widgets = array_filter($modules, function ($module) use ($name) {
                return $module->position === $name;
            })) {

                $return[$name] = array();

                foreach ($widgets as $widget) {
                    $return[$name][] = array("id" => $widget->id, "title" => $widget->title);
                }
            }
        }

        return $return;
    }
}
