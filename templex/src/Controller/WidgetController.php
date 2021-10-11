<?php

namespace Templex\Controller;


use Templex\Helper\TemplateHelper;
use Templex\Helper\WidgetsHelper;
use Templex\Helper\PathHelper;
use Templex\Helper\ConfigHelper;
use Templex\Helper\SystemHelper;
use Templex\Templex;
use ArrayObject;

class WidgetController extends ArrayObject
{

    public function __construct(Templex $Templex)
    {
        $templateHelper = new TemplateHelper($Templex);


        $widgetsHelper = new WidgetsHelper($Templex);
        $configHelper = new ConfigHelper();
        $pathHelper = new PathHelper();
        $systemHelper = new SystemHelper();
        $Templex->setData(array('config' => $configHelper, 'template' => $templateHelper, 'widgets' => $widgetsHelper, 'path' => $pathHelper, 'system' => $systemHelper));
        $templateHelper->setWidgetsData($Templex->data);
        $widgetsHelper->setTemplateData($Templex->data);

        parent::__construct($Templex->data);
    }


    public function loadWidgets()
    {

        return true;
    }
}
