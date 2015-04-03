        <form method="post" action="/event/addEvent">
            1. Booked for: <br />
            <select name=username size=1>
                <?php
                foreach ($vars['users'] as $key => $value)
                {
                    //var_dump($vars['users']);
                    echo '<option value = ' . $value['id'] . ' > ' . $value['name'] . ' ' . $value['surname'] . ' </option>';
                }
                ?> 
            </select><br/>
            2. I would like to book this meeting:<br />
            <select name=month size=1>
                <option value=1>Jan</option>
                <option value=2>Feb</option>
                <option value=3>Mar</option>
                <option value=4>Apr</option>
                <option value=5>May</option>
                <option value=6>Jun</option>
                <option value=7>Jul</option>
                <option value=8>Aug</option>
                <option value=9>Sep</option>
                <option value=10>Oct</option>
                <option value=11>Nov</option>
                <option value=12>Dec</option>
            </select>
            <select name=days size=1>
                <?php
                for ($i = 1; $i <= 30; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select> 
            <select name=year size=1>
                <?php
                for ($i = 2014; $i <= 2016; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select> 
            3. Specify what the time and end of the meeting.<br />
            <select name=hourStat size=1>
                <?php
                for ($i = 1; $i <= 12; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select>          
            <select name=minutStat size=1>
                <?php
                for ($i = 1; $i <= 60; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select>         
            <select name=timePrefStart size=1>
                <?php
                for ($i = 1; $i <= 60; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select> <br/>          

            <select name=hourEnd size=1>
                <?php
                for ($i = 1; $i <= 12; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select>           
            <select name=minutEnd size=1>
                <?php
                for ($i = 1; $i <= 60; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select>           
            <select name=timePrefEnd size=1>
                <?php
                for ($i = 1; $i <= 60; $i++)
                {
                    echo "<option value=$i>$i</option>";
                }
                ?>
            </select><br/>
            4. Enter the specifics for the meeting. <br />
            <textarea name=meetingSpecText rows=5 wrap=Virtual>
            </textarea>
            5. Is this going to be a recurring event?<br/>
            <input type=radio name=recurringEvent value=yes checked>Yes
            <input type=radio name=recurringEvent value=no>No<br/>
            6. If it is recurring , specify weekly, bi-weekly, or month. <br/>
            <input type=radio name=recurringSpecify value=weekly checked>weekly
            <input type=radio name=recurringSpecify value=biWeekly checked>bi-weekly
            <input type=radio name=recurringSpecify value=month > <br/>
            7. Duration
            <input type=text name=durationEvents maxlen=1><br/>
     

        <br />
        <input type="submit" name="submit" value="Submit" />
    </form>
