
<html>
    <head>
        <title><?php echo isset($vars['title']) ? $vars['title'] : 'Boardroom Booker'; ?></title>
        <link rel="stylesheet" href="/css/style.css" media="screen" />
        <script type='text/javascript' src='/js/jquery-2.1.3.min.js'></script>
        <script type='text/javascript' src='/js/booker.js'></script>
        <meta http-equiv="Content-Type"
              content="text/html;charset=UTF-8">

    </head>

    <body>
        <div id="durationError" class="flashError"></div>
        <?php
        // var_dump($flash);
        if (!empty($flash))
        {
            // var_dump($flash);
            echo '<div class = "flashError">';
            foreach ($flash as $value)
            {
                echo "$value";
                echo '</br>';
            }
            echo '</div>';
        }
        ?>
        <div>
            <a href="/User/logout/?logout=true">
                <div align="right">logout</div>
            </a>
            <div id="boardrooms"  style="text-align:center; width: 100%;">

                <?php
                foreach ($vars['boardrooms'] as $key => $value)
                {
                    if ($value['id'] === $vars['currentRoom'])
                    {
                        echo '<a href=?room=' . $value['id'] . ' class="roomlink"><div class="left boardroomCurrent" >' . $value['name'] . '</div></a>';
                    } else
                    {
                        echo '<a href=?room=' . $value['id'] . ' class="roomlink"><div class="boardroom left" >' . $value['name'] . '</div></a>';
                    }
                }
                ?>
            </div>
            <div class="clear">

            </div>

            <div id="main">
                <div id="month" class="month">
                    <a href="/?month=<?php echo $vars['prevMonth']; ?>&year=<?php echo $vars['prevYear']; ?>">
                        <div id="previousMonth" class="left"><img src="/img/left50.png"/></div>
                    </a>
                    <div id="monthCurrent" class="left">
                        <?php
                        echo $vars['currentMonth'] . ' ' . $vars['year'];
                        ?>
                    </div>
                    <a href="/?month=<?php echo $vars['nextMonth']; ?>&year=<?php echo $vars['nextYear']; ?>">
                        <div id="nextMonth" class="left"><img src="/img/right50.png"/></div>
                    </a>
                </div>
                <div id="calendarMain" class="" style="clear: both;"></div>
                <?php
                foreach ($templates as $template)
                {
                    include $template;
                }
                ?>            
                <div id="helper" style="float: left;">
                    <a href="/Event/addEvent" class="butt">
                        <div id="employeeList" class="button">book it</div>
                    </a>
                    <a class="butt" href="<?php echo '/user/getUsers'; ?>">                        
                        <div id="employeeList" class="button">Employee list</div>
                    </a>
                </div>
            </div>
            <div id="eventdetails" class="details">
                <div class="clear">
                    <div style="width: 50px;float: left">When:</div>
                    <input type="TEXT" id="dateStart" style="width: 60px;float: left"></input>
                    <input type="TEXT" id="dateEnd" style="width: 60px;float: left"></input>
                </div>
                <div   class="clear">
                    <div style="width: 50px;float: left">Notes:</div>
                    <input type="TEXT" id = "description" style="width: 100px;float: left"></input>
                </div>
                <div   class="clear">
                    <div style="width: 50px;float: left">Who:</div>
                    <input type="TEXT" id = "user" style="width: 200px;float: left"></input>
                </div>
                <div   class="clear">
                    <div style="width: 50px;float: left">Submitted:</div>
                    <input type="TEXT" id = "dateSubmitted" style="width: 200px;float: left"></input>
                </div>
                <div class="clear">
                    <input type=checkbox name="deleteAllEvent" value="TRUE" >
                    <span> Apply to all occurrences? </span>
                </div>
                <div>
                    <a href="/Event/updateEvent" style="float: left" id = "update"><div class="button">Update</div></a>
                    <a href="/Event/deleteEvent"style="float: left" id = "delete"><div class="button">Delete</div></a>
                    <div>
                        <input type="hidden" id="eventDate" ></input>
                        <input type="hidden" id="recurrentId" ></input>
                        <input type="hidden" id="eventId" ></input>
                    </div>

                </div>
            </div>

        </div>

    </body>

</html>

