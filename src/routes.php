<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function ($request, $response, $args) {
    $endpoints = [
      'all tasks' => $this->api['api_url'].'/todos',
      'single tasks' => $this->api['api_url'].'/todos/{task_id}',
      'help' => $this->api['base_url'].'/',
    ];
    $result = [
      'endpoints' => $endpoints,
      'version' => $this->api['version'],
      'timestamp' => time(),
    ];
    return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
$app->group('/api/v1/todos', function() use($app) {
    $app->get('', function (Request $request, Response $response, array $args) {
      $result = $this->task->getTasks();
      return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
$app->get('/{task_id}', function (Request $request, Response $response, array $args) {
      $result = $this->task->getTask($args['task_id']);
      return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
$app->post('', function (Request $request, Response $response, array $args) {
      $result = $this->task->createTask($request->getParsedBody());
      return $response->withJson($result, 201, JSON_PRETTY_PRINT);
    });
$app->put('/{task_id}', function (Request $request, Response $response, array $args) {
      $data = $request->getParsedBody();
      $data['task_id'] = $args['task_id'];
      $result = $this->task->updateTask($data);
      return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
$app->delete('/{task_id}', function (Request $request, Response $response, array $args) {
      $result = $this->task->deleteTask($args['task_id']);
      return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
});
