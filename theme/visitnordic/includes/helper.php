<?php

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

class vnTemplateHelper
{
	public				$type			= null;
    public              $error          = null;
    protected           $document       = null;
    protected   static  $instances      = array();


    private function __construct($document)
    {
        $this->document = $document;
		
		$info = pathinfo($document->_file);
		$type = $info['filename'];

        if ($type == 'error')
        {
            $this->error = $this->document->error;
        }

        $this->type = $type;
    }


    public static function getInstance($document = null)
    {
        $id = $document->_file;

        if (!isset(static::$instances[$id]))
        {
            static::$instances[$id] = new vnTemplateHelper($document);
        }
		
        return static::$instances[$id];
    }


	public function getPageType()
	{
		return $this->type;
	}
	
	
    public function isErrorPage()
    {
        return ($this->getPageType() == 'error');
    }


    public function countModules($position = '')
    {
        if ($this->getPageType() == 'index')
        {
            return $this->document->countModules($position);
        }

        if ($this->getPageType() == 'error')
        {
            return count(ModuleHelper::getModules($position));  // Updated for Joomla 4
        }

        return 0;
    }


    public function renderModules($position = '', $style = 'none', $showOnError = false)
    {
		if ($this->getPageType() == 'index')
		{
			$this->output('<jdoc:include type="modules" name="'. $position .'" style="'. $style .'" />');
		}
        
		if ($this->getPageType() == 'error' && $showOnError)
        {
            $modules    = JModuleHelper::getModules($position);
            $buffer     = '';

            foreach ($modules as $module)
            {
                $buffer .= JModuleHelper::renderModule($module, array('style' => $style));
            }

            return $this->output($buffer);
        }
    }


    public function renderHead()
    {
        $this->outputFile('head.php');
    }


    public function renderMessage()
    {
		$this->outputFile('message.php');
    }


    public function renderComponent()
    {
        $this->outputFile('component.php');
    }

    protected function output($content = '')
    {
        echo $content;
    }


    protected function outputFile($file = '')
    {
        $path = __DIR__ .'/'. $this->getPageType() .'/'. $file;

        if (!file_exists($path))
        {
            return true;
        }

        ob_start();
        include $path;
        $buffer = ob_get_contents();
        ob_end_clean();

        $this->output($buffer);
    }
}
