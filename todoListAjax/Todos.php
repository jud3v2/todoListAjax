<?php

require_once 'Database.php';

class Todos
{
        /**
         * @var PDO|Database
         */
        public PDO|Database $db;

        public function __construct()
        {
                $this->db = new Database();
        }

        public function getTodos(): false|array
        {
                $query = $this->db->query('SELECT * FROM todos');
                return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTodoById($id)
        {
                return $this->db->fetch("SELECT * FROM todos WHERE id = $id");
        }

        public function addTodo($data)
        {
                return $this->db->insert('todos', $data);
        }

        public function updateTodoById($id, $data)
        {
                $todo = $this->getTodoById($id);
                if($todo) {
                        if($todo['completed'] === 1) {
                                $data['completed'] = 0;
                        } else {
                                $data['completed'] = 1;
                        }
                        return $this->db->update('todos', $data, "id = $id");
                } else {
                        echo json_encode(['error' => 'Todo not found']);
                }
        }

        public function deleteTodoById($id)
        {
                return $this->db->delete('todos', "id = $id");
        }
}

$todo = new Todos();

$_POST = json_decode(file_get_contents('php://input'), true);

if($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($todo->getTodos());
} elseif($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(!empty($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'update') {
                http_response_code(201);
                echo json_encode($todo->updateTodoById($_GET['id'], $_POST));
                exit();
        }

        if(!empty($_GET['id']) && isset($_GET['action']) && $_GET['action'] === 'delete') {
                http_response_code(200);
                echo json_encode($todo->deleteTodoById($_GET['id']));
                exit();
        }

        http_response_code(201);
        echo json_encode($todo->addTodo($_POST));
} else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
