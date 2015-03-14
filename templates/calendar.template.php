<div id="calendar" class="Calendar" style="float: left;">
    <div id="helper"> </div>
    <table border="1">
        <tbody>

            <?php
            $calendarData = $vars['calendarData'];
            $count = $calendarData['firstDayweek'] + 1;
            $firstDayMonth = $calendarData['firstDayMonth'];
            $countDay = 0;
            //  var_dump($count);
            echo '<tr>';
            if ($firstDayMonth != 0) {
                for ($i = 0; $i < $firstDayMonth; $i++) {
                    echo '<td class="cell"> </td>';
                    $countDay++;
                    if ($countDay == 6) {
                        echo '</tr> <tr>';
                        $countDay = 0;
                    }
                }
            }
            
            for ($i = 1; $i < $calendarData['countDayMonth'] + 1; $i++) {
                echo '<td class="cell">' . $i . '</td>';
                $countDay++;
                var_dump($countDay);
                if ($countDay > 6) {
                    echo '</tr> <tr>';
                    $countDay = 0;
                }
            }
            ?>


        </tbody>
    </table>
</div>