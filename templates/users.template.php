<html>
    <head>
        <title>Users list 
        </title>
    </head>

    <body>
        <?php
       // var_dump($vars['usersData']);
        foreach ($vars['usersData'] as $data)
        {
            echo '<div id="emploee" class="employee">
            <div>
                <a href="mailto:'.$data['mail'].'">
                    '.$data['name'].' '.$data['surname'].'
                </a>
            </div>
            
        </div>';
        }
        ?>
    </body>
</html>