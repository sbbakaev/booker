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
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
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
        }
    }

    /**
     * Создает нового пользователся и его настроек.
     */
    public function addUser()
    {
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
        $logined = UserController::checkAuth('UserController', 'login');
        if ($logined)
        {
            $res = $this->model->userList(array());
            $this->view->setVar('usersData', $res);
            $this->view->addTemplate('users')->render();
        }
    }

    /**
     * Удаляет сотрудника из системы.
     */
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
