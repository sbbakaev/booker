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

    public function editUser()
    {
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
            //var_dump($this->dataGet);
            $this->view->setMainTemplate('blank');
            if (isset($this->dataPost['name']))
            {
                var_dump($this->dataPost);
                $data['idUser'] = $this->dataPost['userid'];

                if (isset($this->dataPost['password']) && $this->dataPost['password'] != '')
                {
                    $data['password'] = sha1($this->dataPost['password']);
                }
                $data['surname'] = $this->dataPost['surname'];
                $data['username'] = $this->dataPost['username'];
                $data['id'] = $this->dataPost['userid'];
                $data['idUser'] = $this->dataPost['userid'];
                $data['firstDayWeek'] = $this->dataPost['firstdayweek'];
                $data['isAdmin'] = $this->dataPost['userRights'];
                $data['timeFormat24'] = $this->dataPost['timeFormate'];
                $data['idUser'] = $this->dataPost['userid'];
                $this->model->updateUser($data);
            } else
            {
                $data['userId'] = $this->dataGet['userid'];
                $res = $this->model->getUserDetails($data);
                var_dump($res[0]['id']);
                $this->view->setVar('vars', $res);
                $this->view->addTemplate('edituser')->render();
            }
        }
    }

    public function addUser()
    {
        $this->view->setMainTemplate('blank');
        //var_dump($this->dataPost);
        if (isset($this->dataPost['name']) && $this->dataPost['name'] != '')
        {
            $dataUser['mail'] = $this->dataPost['mail'];
            $dataUser['name'] = $this->dataPost['name'];
            $dataUser['surname'] = $this->dataPost['surname'];
            $dataUser['password'] = sha1($this->dataPost['password']);
            $dataUser['username'] = $this->dataPost['username'];


            $inserId = $this->model->createUser($dataUser);
            $dataPreference['idUser'] = $inserId;
            $dataPreference['timeFormat24'] = $this->dataPost['timeFormate'];
            $dataPreference['firstDayWeek'] = $this->dataPost['firstdayweek'];
            $dataPreference['isAdmin'] = $this->dataPost['userRights'];
            // var_dump($dataPreference);
            $this->model->addPreference($dataPreference);
            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host/user/getUsers");
        } else
        {
            $this->view->addTemplate('newuser')->render();
        }
        /*  $host = $_SERVER['HTTP_HOST'];
          header("Location: http://$host/user/getUsers"); */
        exit;
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
            //  var_dump($res);
            $this->view->setVar('usersData', $res);
            $this->view->addTemplate('users')->render();
        }
    }

    public function deleteUser()
    {
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
            $data['userid'] = $this->dataGet['userid'];
            $res = $this->model->deleteUser($data);
            $this->view->setVar('usersData', $this->model->userList(array()));
            $this->view->addTemplate('users')->render();
        }
    }

}
