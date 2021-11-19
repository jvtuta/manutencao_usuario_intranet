<?php

require '../connection/dbConfig.php';

$db = Db::getDb();
$usuarios = Usuario::all($db);

function startApi($server) {
    $requestApi = new Request($server);
    
    new Route(
        $requestApi->getRequest(),
        UserController::class, 
        $requestApi->getMethod(),
        'user'
    );
    
}

startApi($_SERVER);

class Request {
    private $request;
    private $method;

    public function __construct($SERVER)
    {
        $this->request = $SERVER['REQUEST_URI'];
        $this->setMethod($SERVER['REQUEST_METHOD']);
    }

    public static function response($data) 
    {
        echo json_encode($data);
    }

    private function setMethod($request_method) 
    {
        $this->method = $request_method;
    }

    public function getMethod() 
    {
        return $this->method;
    }

    public function getRequest() 
    {
        return $this->request;
    }

    public function getQuery()
    {
        return parse_url($this->request, PHP_URL_QUERY);
    }

}

class Route {
    // Atraves da rota o controller e a request serão chamados
    public function __construct($route, $controller, $method, $name)
    {
        $this->initializer($route, $controller, $method, $name);
    }

    private function initializer($route, $controller, $method, $name)
    {
        $route = parse_url($route,PHP_URL_QUERY);
        return new $controller($route, $method, $name);
    }
}

abstract class Controller {
    // controller irá manipular o model(de acordo com a request e a rota) e retornar uma resposta em json 
    protected $name, $method;
    public $query;
    public function __construct($query = null, $method, $name)
    {
        $this->query = $query;
        $this->name = $name;
        $this->method = $method;
        $this->setAction();
    }
    // Chamar a função correta de acordo com o metodo
    private function setAction() 
    {
        switch ($this->method) {
            case 'get':
                if($this->query) {
                    return $this->index($this->query);
                }
                return $this->index();
                break;
            case 'post':
                if($this->query) {
                    return $this->update($this->query);
                }
                return $this->create($this->query);
            default:
                echo 'Method not allowed';
                return;
                break;
        }    
    }
    // tipo de metodo irá definir a ação a ser tomada;
    abstract protected function create($data);
    abstract protected function update($query = null);
    abstract protected function index($query = null);
}

class UserController extends Controller {
    
}

class Model extends Db {
    private $model, $id, $db, $column;

    public function __construct($id = null, $db = null, $column = null, $model)
    {
        $this->id = $id;
        $this->db = $db;
        $this->column = $column;
        $this->model = $model;
    }
    
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

}

Request::response($usuarios);
?>