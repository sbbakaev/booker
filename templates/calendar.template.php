<div id="calendar" class="Calendar" style="float: left;">
    <div id="helper"> </div>
    <table border="1">
        <tbody>

            <?php
            $calendarData = $vars['calendarData'];
            $firstDayMonth = $calendarData['firstDayMonth'];
            $firstDayWeek = $calendarData['firstDayWeek'];
            $events = $vars['res'];
            if ($firstDayWeek == 0)
            {
                echo '<tr><td>Sunday</td>'
                . '<td>Monday</td>'
                . '<td>Tuesday</td>'
                . '<td>Wednesday</td>'
                . '<td>Thursday</td>'
                . '<td>Friday</td>'
                . '<td>Saturday</td></tr>';
            } else
            {
                echo '<tr><td>Monday</td>'
                . '<td>Tuesday</td>'
                . '<td>Wednesday</td>'
                . '<td>Thursday</td>'
                . '<td>Friday</td>'
                . '<td>Saturday</td>'
                . '<td>Sunday</td></tr>';
            }
            $countDay = 0;

            if ($firstDayWeek != 0)
            {
                if ($firstDayMonth == 0)
                {
                    $firstDayMonth = 7;
                }
                $firstDayMonth-=$firstDayWeek;
            }
            if ($firstDayMonth != 0)
            {

                echo '<tr>';
                for ($i = 0; $i < $firstDayMonth; $i++)
                {
                    echo '<td class="cell"></td>';
                    $countDay++;
                    if ($countDay == 7)
                    {
                        echo '</tr>';
                        $countDay = 0;
                    }
                }
            }



            for ($i = 1; $i < $calendarData['countDayMonth'] + 1; $i++)
            {
                if ($countDay == 0)
                {
                    echo '<tr>';
                } elseif ($countDay == 7)
                {
                    echo '</tr>';
                    $countDay = 0;
                }

                echo '<td class="cell">' . $i . '</br>';
               if (isset($events[$i]['id']))
               {
                   echo    $events[$i]['date_start'].'-';
                   echo    $events[$i]['date_end'];
               }
                echo '</td>';
                $countDay++;
            }
            ?>


        </tbody>
    </table>
</div>