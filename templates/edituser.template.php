<form method="post" action="/user/editUser" id = "editUser">
    1. 	Enter new employee name <br />
    <input type=text name="name" id ="name" maxlen=1 value = 
    <?php
    if (isset($vars['vars']['name']))
    {
        echo $vars['vars']['name'];
    }
    ?>> </input><br/>
    2. 	Enter new employee surname <br />
    <input type=text name="surname" id ="surname" maxlen=1 value = 
    <?php
    if (isset($vars['vars']['surname']))
    {
        echo $vars['vars']['surname'];
    }
    ?>> </input><br/>
    3. 	Enter new employee username <br />
    <input type=text name="username" id ="username" maxlen=1 value = 
    <?php
    if (isset($vars['vars']['username']))
    {
        echo $vars['vars']['username'];
    }
    ?>> </input><br/>
    4. 	Enter new employee e-mail<br />
    <input type=text name="mail" id ="mail" maxlen=1 value = 
    <?php
    if (isset($vars['vars']['mail']))
    {
        echo $vars['vars']['mail'];
    }
    ?> 
           > </input><br/>

    5. Enter new employee first day of week <br />
    <select name="firstdayweek" size=1 id="firstdayweek">
        <?php
        if ($vars['vars']['firstDayWeek'] == 0)
        {
            echo '<option value="0"  selected="selected">Sunday</option>
        <option value=1>Monday</option>';
        } else
        {
            echo '<option value="0"  >Sunday</option>
        <option value=1 selected="selected">Monday</option>';
        }
        ?>
    </select><br/>
    6. Enter new employee is administrator <br />
    <select name="userRights" size=1 id = "userRights">
        <?php
        if ($vars['vars']['isAdmin'] == 0)
        {
            echo '<option value="0"  selected="selected">User</option>
        <option value=1>Administrator</option>';
        } else
        {
            echo '<option value="0"  >User</option>
        <option value=1 selected="selected">Administrator</option>';
        }
        ?>
    </select><br/>
    7. Enter new employee time formate <br />
    <select name="timeFormate" size=1 id="timeFormate">
        <?php
        if ($vars['vars']['timeFormat24'] == 0)
        {
            echo '<option value="0"  selected="selected">12</option>
        <option value=1>24</option>';
        } else
        {
            echo '<option value="0" >12</option>
        <option value=1 selected="selected">24</option>';
        }
        ?>        
    </select><br/>
    8. Enter new employee password<br />
    <input  type="password" name="password" id ="password" maxlen=1></input><br/>
    <div>
        <?php
        echo '<input type="hidden" name="userid" value = "';
        if (isset($vars['vars']['idUser']))
        {
            echo $vars['vars']['idUser'] . '"></input>';
        } else
        {
            echo '"></input>';
        }
        ?>
    </div>
    <input type="submit" name="submit" value="Submit" /></input>

</form>
