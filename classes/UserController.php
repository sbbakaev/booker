<?php

class UserController extends Controller
{

    public function __construct($get, $post)
    {
        $this->model = new User;
        $this->view = new Viewer('blank.template');
        parent::__construct($get, $post);
    }

    public function userList()
    {
        $data = array();
        $res = $this->model->userList($data);
        $this->view->addTemplate('asd')->render();
    }

    public function logout()
    {
        if (isset($this->dataGet['logout']))
        {
            session_destroy();
            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host/user/login");
            exit;
        }
    }

    public function login()
    {
        if (isset($this->dataPost['user']) && isset($this->dataPost['password']))
        {
            $username = $this->dataPost['user'];
            $password = $this->dataPost['password'];
            $res = $this->model->getPermision($username, $password);
            if (count($res) > 0)
            {
                $_SESSION['userData'] = $res;
                $host = $_SERVER['HTTP_HOST'];
                $extra = 'calendar.template.php';
                header("Location: http://$host/event/showCalendar");
                exit;
            } else
            {
                exit('empty login result');
            }
        } else
        {
            $this->view->addTemplate('login')->render();
        }
    }

    public static function checkAuth($class, $method)
    {
        if (!session_id())
        {
            session_start();
        }

        if (!isset($_SESSION['userData']))
        {
            if ($class != 'UserController' && $method != 'login')
            {
                $host = $_SERVER['HTTP_HOST'];
                $extra = 'calendar.template.php';
                header("Location: http://$host/user/login");
                exit;
            }
        } else
        {

            return TRUE;
        }
    }

    public function getUsers()
    {
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
            $res = $this->model->userList(array());
            //var_dump($res);
            $this->view->setVar('usersData', $res);
            $this->view->addTemplate('users')->render();
        }
    }

    public function deleteUser()
    {
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
            $res = $this->model->deleteUser(array());
            //var_dump($res);
            $this->view->setVar('usersData', $res);
            $this->view->addTemplate('users')->render();
        }
    }

}
