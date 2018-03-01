<?php 
namespace App\Models;

use Core\BaseModel;
use PDO;

class Pais extends BaseModel
{
    protected $table = "pais";
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
