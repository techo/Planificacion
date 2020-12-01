<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Gestion extends BaseModel
{
    protected $table = "dplanificacion";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function select()
    {
       
    }
}
