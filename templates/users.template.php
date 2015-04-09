<html>
    <head>
        <title>Users list 
        </title>
    </head>

    <body>
        <div>
            <?php
            foreach ($vars['usersData'] as $data)
            {
                {
                    echo '<a href=mailto:='. $data ['mail'].' class="booker"><div style="width: 200px;float: left">' . $data['name'] . ' ' . $data['surname'] . '</div></a>';
                    echo '<a href=/user/deleteUser/?userid='. $data ['id'] . ' class="booker"><div style="width: 200px;float: left">REMOVE</div></a>';
                    echo '<a href=/user/editUser/?userid=' . $data ['id'] . ' class="booker"><div style="width: 200px;float: left">EDIT</div></a>';
                    echo '<div class="clear"></div>';
                }/*
                  echo '<div >
                  <div>
                  <a href="mailto:' . $data['mail'] . '" class="employee">
                  ' . $data['name'] . ' ' . $data['surname'] . '
                  </a>
                  </div>

                  <div>'.
                  '<a href=" userId ='. $data['id']. '" class="employee">REMOVE</a>
                  </div>

                  </div>  <div class = "clear"></div>'; */
            }
            ?>
            <a href="/User/addUser">
                <div id="employeeList" class="button">Add user</div>
            </a>
        </div>
    </body>
</html>