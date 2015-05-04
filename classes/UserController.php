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
                //                  $this->checkDoubleUser($this->dataPost['username'], $this->dataPost['userid']);
            }
            /*
              if (!$this->checkDoubleUser($this->dataPost['username'], $this->dataPost['userid']))
              {
              $error = "Username is allready exist.";
              User::setFlash($error, 'errors');
              $this->view->addTemplate('newuser')->render();
              exit;
              }
              } */
            $this->view->setMainTemplate('blank');
            /* if (isset($this->dataPost['name']))
              { */
            $this->validate("editUser");
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
        } /* else
          {
          $data['userId'] = $this->dataGet['userid'];
          $res = $this->model->getUserDetails($data);
          $this->view->setVar('vars', $res[0]);
          $this->view->addTemplate('edituser')->render();
          }
          } */ else
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
                $this->checkDoubleUser($this->dataPost['username'], null);
                /* if (!$this->checkDoubleUser($this->dataPost['username'], null))
                  {
                  $error = "Username is allready exist.";
                  User::setFlash($error, 'errors');
                  $this->view->addTemplate('newuser')->render();
                  exit;
                  } */
            }

            $this->view->setMainTemplate('blank');

            if (isset($this->dataPost['name']) && $this->dataPost['name'] != '')
            {
                $this->validate("addUser");


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
                foreach ($this->dataPost as $key => $value)
                {
                    $error = "you don`t enrtry correct data.";
                    User::setFlash($error, 'errors');
                    $this->view->setVar($key, $value);
                }
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

    private function validate($method)
    {

        $validate = true;
        $message = "";
        if (count($this->dataPost) > 0)
        {
            if (!isset($this->dataPost['mail']) || $this->dataPost['mail'] == "")
            {
                $validate = false;
                $message = $message . "Enter a mail. ";
            } else
            {
                if (preg_match("/@/", $this->dataPost['mail']) < 1)
                {
                    $validate = false;
                    $error = 'Your e-mail must contain "@".';
                    User::setFlash($error, 'errors');
                }
            }

            if (!isset($this->dataPost['name']) || $this->dataPost['name'] == "")
            {
                $validate = false;
                $message = $message . "Enter a name. ";
            } else
            {
                $tmp = User::validate($this->dataPost['name']);
                if (!$tmp)
                {
                    $validate = $tmp;
                }
            }

            if (!isset($this->dataPost['surname']) || $this->dataPost['surname'] == "")
            {
                $validate = false;
                $message = $message . "Enter a surname. ";
            } else
            {
                $tmp = User::validate($this->dataPost['surname']);
                if (!$tmp)
                {
                    $validate = $tmp;
                }
            }

            if (!isset($this->dataPost['password']) || $this->dataPost['password'] == "")
            {
                $validate = false;
                $message = $message . "Enter a password. ";
            } else
            {
                if (strlen($this->dataPost['password']) < 4)
                {
                    $validate = false;
                    $error = "Your password must contain 4 symbols.";
                    User::setFlash($error, 'errors');
                }
                $tmp = User::validate($this->dataPost['password']);
                if (!$tmp)
                {
                    $validate = $tmp;
               }
            }

            if (!isset($this->dataPost['username']) || $this->dataPost['username'] == "")
            {
                $validate = false;
                $message = $message . "Enter a username. ";
            } else
            {
                $tmp = User::validate($this->dataPost['username']);
                if (!$tmp)
                {
                    $validate = $tmp;
                }
            }

            if (!$validate)
            {
                User::setFlash($message, 'errors');
            }
            if (!$validate)
            {
                $error = "You need entre correct data. Only chars and number.";
                User::setFlash($error, 'errors');
            }
        } else
        {
            $data['userId'] = $this->dataGet['userid'];
            $res = $this->model->getUserDetails($data);
            $this->view->setVar('vars', $res[0]);
            $this->view->addTemplate('edituser')->render();
            exit;
        }
        if (!$validate)
        {

            if ($method == "editUser")
            {
                if (count($this->dataPost) > 0)
                {
                    foreach ($this->dataPost as $key => $value)
                    {
                        $arr[$key] = $value;
                    }
                    $this->view->setVar('vars', $arr);
                    $this->view->addTemplate('edituser')->render();
                } elseif (count($this->dataGet) > 0)
                {
                    $data['userId'] = $this->dataGet['userid'];
                    $res = $this->model->getUserDetails($data);
                    $this->view->setVar('vars', $res[0]);
                    $this->view->addTemplate('edituser')->render();
                }
            } else
            {
                foreach ($this->dataPost as $key => $value)
                {
                    $this->view->setVar($key, $value);
                }
                $this->view->addTemplate('newuser')->render();
            }

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
                //$extra = 'calendar.template.php';
                header("Location: http://$host/event/showCalendar");
                exit;
            } else
            {
                $error = "Username or password is wrong. Please enter correct data.";
                User::setFlash($error, 'errors');
                $this->view->addTemplate('login')->render();
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

    public function checkDoubleUser($param, $idUser)
    {
        $data['username'] = $this->dataPost['username'];
        if (isset($idUser) && $idUser != NULL)
        {
            $data['id'] = $idUser;
        }
        $res = $this->model->getUserUsername($data);

        if ($res[0]['count'] > 0)
        {
            foreach ($this->dataPost as $key => $value)
            {
                $this->view->setVar($key, $value);
            }
            $error = "Username is allready exist.";
            User::setFlash($error, 'errors');
            $this->view->addTemplate('newuser')->render();
            exit;
        }
    }

}
