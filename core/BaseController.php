<?php 

namespace Core;

abstract class BaseController
{
    protected $view;
    private   $path;
    private   $layoutPath;
    private   $title = null;
    
    public function __construct()
    {
        $this->view = new \stdClass;
        session_start();
        if(!isset($_SESSION['Planificacion']['token']))
        {
            header('Location: http://login.techo.org/');
        }
    }
    
  protected function renderView($path, $layoutPath = null)
  {
      $this->path       = $path;
      $this->layoutPath = $layoutPath;
      
      if($layoutPath)
      {
          $this->layout();
      }
      else
      {
          $this->content();
      }
  }
  
  protected function content()
  {
      if(file_exists(__DIR__ . "/../app/Views/{$this->path}.phtml"))
      {
          require_once __DIR__ . "/../app/Views/{$this->path}.phtml";
      }
      else
      {
          echo('Error: View path not found.');
      }
  }
  
  protected function layout()
  {
      if(file_exists(__DIR__ . "/../app/Views/{$this->layoutPath}.phtml"))
      {
          require_once __DIR__ . "/../app/Views/{$this->layoutPath}.phtml";
      }
      else
      {
          echo('Error: Layout path not found.');
      }
  }
  
  protected function setPageTitle($title)
  {
      $this->title = $title;
  }
  
  protected function getPageTitle($separator = null)
  {
      if($separator)
      {
          echo($this->title . " " . $separator . " ");
      }
      else
      {
          echo($this->title . " ");
      }
  }
    
}
