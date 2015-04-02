
<html>
    <head>
        <title><?php $title; ?></title>
        <link rel="stylesheet" href="/css/style.css" media="screen" />
        <script type='text/javascript' src='/js/jquery-2.1.3.min.js'></script>
        <script type='text/javascript' src='/js/booker.js'></script>
        <meta http-equiv="Content-Type"
              content="text/html;charset=UTF-8">

    </head>

    <body>

        <div id="boardrooms" style="text-align:center; width: 100%;">
            <?php
            foreach ($vars['boardrooms'] as $boardroom)
            {
                echo "<div>$boardroom</div>";
            }
            ?></div>

        <div id="main">
            <div id="month" class="month">
                <a href="/?month=<?php echo $vars['prevMonth']; ?>&year=<?php echo $vars['prevYear']; ?>">
                    <div id="previousMonth" style="border: medium solid; float: left;"><</div>
                </a>
                <div id="monthCurrent" style="border: medium solid; float: left;">
                    <?php
                    echo $vars['currentMonth'];
                    ?>
                </div>
                <a href="/?month=<?php echo $vars['nextMonth']; ?>&year=<?php echo $vars['nextYear']; ?>">
                    <div id="nextMonth" style="border: medium solid; float: left;">></div>
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
                <a href="/Event/addEvent">
                <div id="employeeList" class="button">book it</div>
                </a>
                <a href="<?php echo '/user/getUsers'; ?>">                        
                <div id="employeeList" class="button">Employee list</div>
                 </a>
            </div>
        </div>


    </body>

</html>

