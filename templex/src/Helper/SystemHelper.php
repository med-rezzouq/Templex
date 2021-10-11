<?php

namespace Templex\Helper;


use Templex\Templex;


class SystemHelper
{

    public function __construct()
    {


        jimport('joomla.filesystem.folder');

        // init vars
        $this->application = \JFactory::getApplication();
        $this->document    = \JFactory::getDocument();
        $this->language    = \JFactory::getLanguage();
        $this->path        = JPATH_ROOT;
        $this->url         = rtrim(\JURI::root(false), '/');
        $this->cache_path  = $this->path . '/media/template';
        $this->cache_time  = max(\JFactory::getConfig()->get('cachetime') * 60, 86400);

        // set config or load defaults
        //  $this['config']->load($this['path']->path('theme:config.json') ?: $this['path']->path('theme:config.default.json'));

        // set cache directory
        if (!file_exists($this->cache_path)) {
            \JFolder::create($this->cache_path);
        }
    }


    public function isBlog()
    {

        //get application
        $app = $this->application;


        if ($app->input->get('option') == 'com_tags') {

            if (in_array($app->input->get('view'), array('tag'))) {
                return true;
            }
        }


        if ($app->input->get('option') == 'com_content') {
            if (in_array($app->input->get('view'), array('frontpage', 'article', 'archive', 'featured')) || ($app->input->get('view') == 'category' && $app->input->get('layout') == 'blog')) {
                return true;
            }
        }

        if ($app->input->get('option') == 'com_zoo' && !in_array($app->input->get('task'), array('submission', 'mysubmissions')) && $a = \App::getInstance('zoo')->zoo->getApplication() and $a->getGroup() == 'blog') {
            return true;
        }

        return false;
    }
}
