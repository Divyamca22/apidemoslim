<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/students/all', function (Request $request, Response $response, array $args) {
    $sql="SELECT * FROM register";
    try{
        $db=new DB();
        $conn=$db->connect();

        $stmt=$conn->query($sql);
        $students=$stmt->fetchAll(PDO::FETCH_OBJ);

        $db=null;
        $response->getBody()->write(json_encode($students));
        return $response
             ->withHeader('content-type','application/json')
             ->withStatus(200);
    }
    catch(PDOException $e){
        $error=array("message"=>$e->getMessage());
        $response->getBody()->write(json_encode($error));
        return $response
             ->withHeader('content-type','application/json')
             ->withStatus(500);

    }
});

    $app->get('/students/{id}', function (Request $request, Response $response, array $args) {
        $id=$args['id'];
        $sql="SELECT * FROM register where register_id=$id";
        try{
            $db=new DB();
            $conn=$db->connect();
    
            $stmt=$conn->query($sql);
            $student=$stmt->fetch(PDO::FETCH_OBJ);
    
            $db=null;
            $response->getBody()->write(json_encode($student));
            return $response
                 ->withHeader('content-type','application/json')
                 ->withStatus(200);
        }
        catch(PDOException $e){
            $error=array("message"=>$e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                 ->withHeader('content-type','application/json')
                 ->withStatus(500);
    
        }
    });

    $app->post('/students/add', function (Request $request, Response $response, array $args) {
       $name=$request->getParam('name');
       $password=$request->getParam('password');
       $status=$request->getParam('status');

        $sql="INSERT INTO register (name, password, status) VALUE (:name, :password, :status)";
        try{
            $db=new DB();
            $conn=$db->connect();
    
            $stmt=$conn->prepare($sql);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':status',$status);

            $result=$stmt->execute();
    
            $db=null;
            $response->getBody()->write(json_encode($result));
            return $response
                 ->withHeader('content-type','application/json')
                 ->withStatus(200);
        }
        catch(PDOException $e){
            $error=array("message"=>$e->getMessage());
            $response->getBody()->write(json_encode($error));
            return $response
                 ->withHeader('content-type','application/json')
                 ->withStatus(500);
    
        }
    });

    $app->delete('/students/{id}', function (Request $request, Response $response, array $args) {
        $id=$args['id'];
 
         $sql="DELETE FROM register Where register_id=$id";
         try{
             $db=new DB();
             $conn=$db->connect();
     
             $stmt=$conn->prepare($sql);
            
             $result=$stmt->execute();
     
             $db=null;
             $response->getBody()->write(json_encode($result));
             return $response
                  ->withHeader('content-type','application/json')
                  ->withStatus(200);
         }
         catch(PDOException $e){
             $error=array("message"=>$e->getMessage());
             $response->getBody()->write(json_encode($error));
             return $response
                  ->withHeader('content-type','application/json')
                  ->withStatus(500);
     
         }
     });


