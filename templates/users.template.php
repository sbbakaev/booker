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
                    echo '<a href=mailto:="' . $data ['mail'] . '" class="booker"><div style="width: 200px;float: left">' . $data['name'] . ' ' . $data['surname'] . '</div></a>';
                    echo '<a href=/user/deleteUser/?userid=' . $data ['id'] . ' class="booker deleteUser"><div style="width: 200px;float: left">REMOVE</div></a>';
                    echo '<a href=/user/editUser/?userid=' . $data ['id'] . ' class="booker "><div style="width: 200px;float: left">EDIT</div></a>';
                    echo '<div class="clear"></div>';
                }
            }
            ?>
            <a href="/User/addUser">
                <div id="employeeList" class="button">Add user</div>
            </a>

            <div id="confirmDelete" class="details">
                <div class="clear">
                    <div style="width: 290px;float: left">Are you sure you want to delete this contact?</div>
                </div>
                <div class="clear">
                    <a href="" style="float: left" id = "ok"><div class="button">ok</div></a>
                    <a href=""style="float: left" id = "cancel"><div class="button">cancel</div></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>