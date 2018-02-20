<?php 
namespace Core;

class Route
{
    private $routes;
    
    public function __construct(array $routes)
    {
        
        $this->setRoutes($routes);
        $this->run();
    }
    
    private function setRoutes($routes)
    {
        foreach ($routes as  $route)
        {
            $explode = explode('@', $route[1]);
            $r = [$route[0], $explode[0], $explode[1]];
            $newRoute[] = $r;
            
        }
        
        $this->routes = $newRoute;
    }
    
    private function getRequest()
    {
        $obj = new \stdClass;
        
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach ($_GET as $key => $value)
        {
            $obj->$key = $value;
        }
        
        foreach ($_POST as $key => $value)
        {
            $obj->$key = $value;
        }
        
        $obj->method = $method;
        
        return $obj;
    }
    
    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    
    private function run()
    {
        $url = $this->getUrl();
        $aURL = explode('/', $url);
        
        foreach ($this->routes as $route)
        {
            $aRoute = explode('/', $route[0]);
                       
            for($i = 0; $i < count($aRoute); $i++)
            {
                if((strpos($aRoute[$i], '{') !== false) && (count($aURL) == count($aRoute)))
                {
                    $aRoute[$i] = $aURL[$i];
                    $aparam[]   = $aURL[$i];
                }
                
                $route[0] = implode($aRoute, '/');
            }
            
            if($url == $route[0])
            {
               $found = true;
               $controller = $route[1];
               $action     = $route[2];
               
               break;
            }
        }
        
        if(count($aparam) > 3)
        {
            $k = count($aparam) - 1;
            $valor = $aparam[$k];
        }
        
        if($found)
        {
            $controller = Container::NewController($controller);
            
            switch (count($aparam))
            {
                case 0:
                    $controller->$action($this->getRequest());
                break;
                
                case 1:
                    $controller->$action($aparam[0], $this->getRequest());
                break;
                
                case 2:
                    $controller->$action($aparam[0], $aparam[1], $this->getRequest());
                break;
                
                case 3:
                    $controller->$action($aparam[0], $aparam[1], $aparam[2], $this->getRequest());
                break;
                
                default:
                    $controller->$action($valor, $this->getRequest());
            }
        }
        else
        {
           Container::pageNotFound();
        }
    }
    
}


