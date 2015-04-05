<html>
    <head>
        <title><?php $title; ?></title>
        <link rel="stylesheet" href="/css/style.css" media="screen" />
        <script type='text/javascript' src='/js/jquery-2.1.3.min.js'></script>
        <script type='text/javascript' src='/js/booker.js'></script>
        <meta http-equiv="Content-Type"
              content="text/html;charset=UTF-8">

    </head>

    <body><?php
        // var_dump($flash);
        if (!empty($flash))
        {
            // var_dump($flash);
            echo '<div>';
            foreach ($flash as $value)
            {
                echo "$value";
                echo '</br>';
            }
            echo '</div>';
        }
        foreach ($templates as $template)
        {
            include $template;
        }
        ?>            
    </body>