<?php

/**
 * Конструктор для работы с сотрудниками.
 * @author Сергей Бакаев <sbbakaev@mail.ru>
 */
class UserController extends Controller
{

    public function __construct($get, $post)
    {
        $this->model = new User;
        $this->view = new Viewer('blank.template');
        parent::__construct($get, $post);
    }

    /**
     * Делает подготовку  данных для редактирования сотрудника и делает 
     * проверку, что сользователь залогинился.
     */
    public function editUser()
    {
        $hasPermision = UserController::checkPermision('UserController', 'addUser');
        if ($hasPermision)
        {
            if (isset($this->dataPost['username']))
            {
                if (!$this->checkDoubleUser($this->dataPost['username']))
                {
                    $error = "Username is allready exist.";
                    User::setFlash($error, 'errors');
                    $this->view->addTemplate('newuser')->render();
                    exit;
                }
            }
            $this->view->setMainTemplate('blank');
            if (isset($this->dataPost['name']))
            {
                $data['name'] = $this->dataPost['name'];

                if (isset($this->dataPost['password']) && $this->dataPost['password'] != '')
                {
                    $data['password'] = sha1($this->dataPost['password']);
                }
                $data['surname'] = $this->dataPost['surname'];
                $data['mail'] = $this->dataPost['mail'];
                $data['username'] = $this->dataPost['username'];
                $data['id'] = $this->dataPost['userid'];
                $data['idUser'] = $this->dataPost['userid'];
                $data['firstDayWeek'] = $this->dataPost['firstdayweek'];
                $data['isAdmin'] = $this->dataPost['userRights'];
                $data['timeFormat24'] = $this->dataPost['timeFormate'];
                $data['idUser'] = $this->dataPost['userid'];
                $this->model->updateUser($data);
                $this->getUsers();
            } else
            {
                $data['userId'] = $this->dataGet['userid'];
                $res = $this->model->getUserDetails($data);
                $this->view->setVar('vars', $res);
                $this->view->addTemplate('edituser')->render();
            }
        } else
        {
            $error = "You don`t have permission to see user list.";
            User::setFlash($error, 'errors');

            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host");
            exit;
        }
    }

    /**
     * Создает нового пользователся и его настроек.
     */
    public function addUser()
    {

        $hasPermision = UserController::checkPermision('UserController', 'addUser');
        if ($hasPermision)
        {
            if (isset($this->dataPost['username']))
            {
                if (!$this->checkDoubleUser($this->dataPost['username']))
                {
                    $error = "Username is allready exist.";
                    User::setFlash($error, 'errors');
                    $this->view->addTemplate('newuser')->render();
                    exit;
                }
            }
            $this->view->setMainTemplate('blank');
            if (isset($this->dataPost['name']) && $this->dataPost['name'] != '')
            {
                $dataUser['mail'] = $this->dataPost['mail'];
                $dataUser['name'] = $this->dataPost['name'];
                $dataUser['surname'] = $this->dataPost['surname'];
                $dataUser['password'] = sha1($this->dataPost['password']);
                $dataUser['username'] = $this->dataPost['username'];
                //создание нового сотрудника
                $inserId = $this->model->createUser($dataUser);
                $dataPreference['idUser'] = $inserId;
                $dataPreference['timeFormat24'] = $this->dataPost['timeFormate'];
                $dataPreference['firstDayWeek'] = $this->dataPost['firstdayweek'];
                $dataPreference['isAdmin'] = $this->dataPost['userRights'];
                //создание записи настроек по сотруднику.
                $this->model->addPreference($dataPreference);
                $host = $_SERVER['HTTP_HOST'];
                header("Location: http://$host/user/getUsers");
                exit;
            } else
            {
                $this->view->addTemplate('newuser')->render();
            }
        } else
        {
            $error = "You don`t have permission to see user list.";
            User::setFlash($error, 'errors');

            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host");
            exit;
        }
    }

    /**
     * Уничтожает сессию, сотрудника.
     */
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

    /**
     * Аутетификация сотрудника, получение прав.
     */
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

    public static function checkPermision($class, $method)
    {
        $array = array('UserController' => array('getUsers', 'addUser', 'deleteUser'));
        $isAdmin = $_SESSION['userData'][0]['isAdmin'];

        if (!$isAdmin)
        {
            if (array_key_exists($class, $array))
            {
                if (in_array($method, $array[$class]))
                {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    /**
     * Проверка авторизации сотрудника. Запись данных в сессию.
     * @param type $class 
     * @param type $method
     * @return boolean TRUE если сотрудник авторизирован.
     */
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

    /**
     * Получает список пользователей. Проходит проверку на права.
     */
    public function getUsers()
    {
        $hasPermision = UserController::checkPermision('UserController', 'getUsers');
        if ($hasPermision)
        {
            $res = $this->model->userList(array());
            $this->view->setVar('usersData', $res);
            $this->view->addTemplate('users')->render();
        } else
        {
            $error = "You don`t have permission to see user list.";
            User::setFlash($error, 'errors');

            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host");
            exit;
        }
    }

    /**
     * Удаляет сотрудника из системы.
     */
    public function deleteUser()
    {
        $hasPermision = UserController::checkPermision('UserController', 'deleteUser');
        if ($hasPermision)
        {
            $data['userid'] = $this->dataGet['userid'];
            $res = $this->model->deleteUser($data);
            $this->view->setVar('usersData', $this->model->userList(array()));
            $this->view->addTemplate('users')->render();
        } else
        {
            $error = "You don`t have permission to delete user.";
            User::setFlash($error, 'errors');

            $host = $_SERVER['HTTP_HOST'];
            header("Location: http://$host");
            exit;
        }
    }

    public function checkDoubleUser($param)
    {
        $data['username'] = $this->dataPost['username'];
        $res = $this->model->getUserUsername($data);
        if ($res[0]['count'] > 0)
        {
            return false;
        } else
        {
            return true;
        }
    }

}
