
<form method="post" action="/user/addUser" id = "newuser">
    1. 	Enter new employee name <br />
    <input type="text" name="name" class = "newuser" id ="name" maxlen=1><br/>
    2. 	Enter new employee surname <br />
    <input type="text" name="surname" class = "newuser" id ="surname" maxlen=1><br/>
    3. 	Enter new employee username <br />
    <input type="text" name="username" class = "newuser" id ="username" maxlen=1><br/>
    4. 	Enter new employee e-mail<br />
    <input type="text" name="mail" class = "newuser" id ="mail" maxlen=1><br/>

    5. Enter new employee first day of week <br />
    <select name="firstdayweek" class = "newuser" size=1 id="firstdayweek">
        <option value=0>Sunday</option>
        <option value=1>Monday</option>
    </select><br/>
    6. Enter new employee is administrator <br />
    <select name="userRights" class = "newuser" size=1 id = "userRights">
        <option value="0">User</option>
        <option value="1">Administrator</option>
    </select><br/>
    7. Enter new employee time formate <br />
    <select name="timeFormate" class = "newuser" size=1 id="timeFormate">
        <option value=0>12</option>
        <option value=1>24</option>
    </select><br/>
    8. Enter new employee password<br />
    <input  type="password" class = "newuser" name="password" id ="password" maxlen=1><br/>

    <input type="submit" name="submit" value="Submit" />
</form>
