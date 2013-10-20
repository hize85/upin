<?php
require '../vendor/autoload.php';

use \Slim\Slim;

// Prepare app
$app = new Slim(array(
    'templates.path' => '../templates',
));

// Web Views
$app->get('/', function () use ($app) {
   $app->render('index.html');     
});
$app->get('/submit', function () use ($app) {
   $app->render('submit.html');     
});

// API
$app->get('/api/posts', 'getPosts');
$app->get('/api/posts/:id', 'getPost');
/* $app->get('/api/search/:query', 'findByName'); */
$app->post('/api/posts', 'addPost');
$app->put('/api/posts/:id', 'updatePost');
$app->delete('/api/posts/:id', 'deletePost');

$app->run();

function getPosts() {
    $sql = "SELECT * FROM posts ORDER BY created DESC";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"posts": ' . json_encode($posts) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getPost($id) {
    $sql = "SELECT * FROM posts WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $posts = $stmt->fetchObject();
        $db = null;
        echo json_encode($posts);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addPost() {
    $request = Slim::getInstance()->request();
    $post = json_decode($request->getBody());
    $sql = "INSERT INTO posts (created, user_id, category, title, description, image, email) VALUES (NOW(), :user_id, :category, :title, :description, :image, :email)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $post->user_id);
        $stmt->bindParam("category", $post->category);
        $stmt->bindParam("title", $post->description);
        $stmt->bindParam("description", $post->description);
        $stmt->bindParam("image", $post->image);
        $stmt->bindParam("email", $post->email);
        $stmt->execute();
        $wine->id = $db->lastInsertId();
        $db = null;
        echo json_encode($post);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updatePost($id) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $post = json_decode($body);
    $sql = "UPDATE post SET user_id=:user_id, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $post->user_id);
        $stmt->bindParam("title", $post->description);
        $stmt->bindParam("description", $post->description);
        $stmt->bindParam("image", $post->image);
        $stmt->execute();
        $db = null;
        echo json_encode($wine);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function deletePost($id) {
    $sql = "DELETE FROM wine WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function findByName($query) {
    $sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"wine": ' . json_encode($posts) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getConnection() {
    $dbhost = "localhost";
    $dbname = "upin_db";
    $dbuser = "upin_user";
    $dbpass = "xg7psGk5l491w0J";
    
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
