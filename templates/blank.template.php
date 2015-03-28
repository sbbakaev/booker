<html>
    <head>
        <title><?php $title; ?></title>
        <link rel="stylesheet" href="/css/style.css" media="screen" />
        <meta http-equiv="Content-Type"
              content="text/html;charset=UTF-8">

    </head>

    <body><?php
        foreach ($templates as $template)
        {
            include $template;
        }
        ?>            
    </body>