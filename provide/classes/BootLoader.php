<?php
/***
 * Copyright (c) 2022 DevRas
 * 
 */

class BootLoader
{
    public function __construct($root)
    {
        $this->root = $root;
        $this->session = new UserSession();

        $this->model = new Template($this->root . "/template");
    }

    protected $root;
    protected $pdo;
    protected $cards;
    protected $config;
    protected $session;
    protected $model;

    public function run()
    {
        try {
            $this->InitPDO();
            $this->cards = new Timecard($this->pdo);
            $this->cards->InitTables();
            $user = new User($this->pdo);

            $isAdmin = false;
            $loginUser = [];
            $works = [];

            $page = filter_input(INPUT_GET, "p") ?? "home";

            if ($user->hasLogout())
            {
                $this->session->setUsername(null);
                header("Location: ?login");
                exit;
            }

            $logged = $this->session->isLogged();
            if (!$logged)
            {
                $loginUser = $user->hasLogin();
                if ($loginUser)
                {
                    $this->session->setUsername($loginUser["username"]);
                    $logged = true;
                } else
                {
                    $this->model->viewModel("login", [
                        "method" => "POST",
                        "canonical" => $this->config["canonical"],
                        "config" => $this->config
                    ]);
                    exit;
                }
            }

            $loginUser = $user->getUser($this->session->getUsername());
            if (!$loginUser)
            {
                throw new \RuntimeException("不正なユーザーです");
            }

            $isAdmin = array_search($this->session->getUsername(), $this->config["admin_users"]) !== false;

            if ($page == "passwd")
            {
                if ($user->hasUpdatePassword($loginUser))
                {
                    header("Location: ?p=home");
                    exit;
                }

                $this->model->viewModel("passwd", [
                    "username" => $this->session->getUsername(),
                    "config" => $this->config,
                ]);
                exit;
            }

            if ($page == "create" && $isAdmin)
            {
                if ($user->hasCreate())
                {
                    header("Location: ?p=home");
                    exit;
                }

                $this->model->viewModel("create", [
                    "config" => $this->config,
                ]);
                exit;
            }

            if ($page == "view")
            {
                $id = filter_input(INPUT_GET, "id");
                $loginUser = $user->getUserById($id);
                if (!$loginUser)
                {
                    throw new \RuntimeException("不正なユーザーです");
                }
            }

            $result = $this->cards->hasCard($loginUser["id"], $isAdmin);
            $works = $this->cards->SelectTimes($loginUser["id"]);
            $lastCard = $this->cards->getLastInsert($loginUser["id"]);

            $users = $this->cards->getUsers();
            $this->model->viewModel("view", [
                "logged" => $logged,
                "users" => $users,
                "user" => $loginUser,
                "works" => $works,
                "canonical" => $this->config["canonical"],
                "config" => $this->config,
                "addCard" => $result,
                "lastCard" => $lastCard,
                "isAdmin" => $isAdmin,
            ]);
        } catch (\RuntimeException $e)
        {
            http_response_code(401);

            $result = $this->model->viewModel("error", [
                "exception" => $e,
                "message" => $e->getMessage(),
                "config" => $this->config,
            ]);

            if (!$result)
            {
                echo $e->getMessage();
                exit;
            }
        }
    }

    protected function InitPDO()
    {
        $config = require_once $this->root . '/config.php';

        $db = new IDB();
        if (!$db->Connect($config["mysql"]["hostname"],
            $config["mysql"]["dbname"],
            $config["mysql"]["username"],
            $config["mysql"]["password"])
        )
        {
            throw new \RuntimeException('can not connect to mysql server.');
        }
        
        $this->pdo = $db->getDB();
        $this->config = $config;
    }
}
