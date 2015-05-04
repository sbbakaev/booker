
$(document).ready(function () {

    $('html').on('click', function () {
        $('#eventdetails').hide();
    });

    $('#eventdetails').on('click', function (event) {
        event.stopPropagation();
    });

    $('#hourStat').val(function () {
        var hourStart = new Date().getHours();
        var minutStat = new Date().getMinutes();
        $('#minutStat').val(minutStat);
        if (hourStart > 12)
        {
            $('#timePrefStart').val("PM")
            hourStart = hourStart - 12;
            return hourStart;
        }
        else {
            $('#timePrefStart').val("AM");
            return hourStart;
        }

    });

    $('#hourEnd').val(function () {
        var hourEnd = new Date().getHours();

        $('#minutEnd').val(59);
        if (hourEnd > 12)
        {
            $('#timePrefEnd').val("PM")
            hourEnd = hourEnd - 12;
            return hourEnd;
        }
        else {
            $('#timePrefEnd').val("AM");
            return hourEnd;
        }

    });

    $('.deleteUser').on('click', function (event) {
        event.preventDefault();
        $('#confirmDelete').show();
        var url = $(this).attr('href');
        $('#ok').attr('href', url);
    })



    $('#days').html(function () {
        var dayCount = new Date($('#year').val(), $('#month').val(), 0).getDate();
        var text = "";
        for (var i = 1; i <= dayCount; i++) {
            text += "<option value=" + i + ">" + i + "</option>";
        }
        $('#days').html(text);
    });
    $('#month').click(function () {
        var dayCount = new Date($('#year').val(), $('#month').val(), 0).getDate();
        var text = "";
        for (var i = 1; i <= dayCount; i++) {
            text += "<option value=" + i + ">" + i + "</option>";
        }
        $('#days').html(text);
    });
    $('#year').change(function () {
        var dayCount = new Date($('#year').val(), $('#month').val(), 0).getDate();
        var text = "";
        for (var i = 1; i <= dayCount; i++) {
            text += "<option value=" + i + ">" + i + "</option>";
        }
        $('#days').html(text);
    });
    $('#days').val(new Date().getDate());
    $('#year').val(new Date().getFullYear());
    $('#month').val(new Date().getMonth() + 1);
    $('#month').click(function () {
        var dayCount = new Date($('#year').val(), $('#month').val(), 0).getDate();
        var text = "";
        for (var i = 1; i <= dayCount; i++) {
            text += "<option value=" + i + ">" + i + "</option>";
        }
        $('#days').html(text);
    });
    $('#year').change(function () {
        var dayCount = new Date($('#year').val(), $('#month').val(), 0).getDate();
        var text = "";
        for (var i = 1; i <= dayCount; i++) {
            text += "<option value=" + i + ">" + i + "</option>";
        }
        $('#days').html(text);
    });
    $('#days').val(new Date().getDate());




    $('.current').on('click', function (event) {
        event.preventDefault();

        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            error: function (res)
            {
            },
            success: function (res) {
                // $('#eventdetails').show();
                $('#dateStart').val(res.date_start);
                $('#dateEnd').val(res.date_end);
                $('#description').val(res.description);
                $('#user').val(res.user);
                // alert($('#user').text());
                $('#dateSubmitted').text(res.dateCreateEvent);
                $('#eventDate').text(res.dateEvent);
                $('#eventId').text(res.eventId);
                $('#recurrentId').text(res.recurrentId);
                $('#eventdetails').show();
            }
        });

        //console.log(url);

    });

    $('#update').on('click', function (event) {
        event.preventDefault();
        var d = new Date();
        var arrStart = $('#dateStart').val().split(':');
        var arrEnd = $('#dateEnd').val().split(':');

        var hourStart = arrStart[0];
        var minutStart = arrStart[1];
        var hourEnd = arrEnd[0];
        var minutEnd = arrEnd[1];
        if ($('#timePrefStart').val() == "PM") {
            hourStart = hourStart + 12;
        }
        if ($('#timePrefEnd').val() == "PM") {
            hourEnd = hourEnd + 12;
        }
        var hourStartTime = new Date(0, 0, 0, hourStart, minutStart);
        var hourEndTime = new Date(0, 0, 0, hourEnd, minutEnd);

        if (hourStartTime.getTime() > hourEndTime.getTime()) {
            $("#messageError").text('Time start must be lower time end').show();
            return false;
        }
        else
        {
            $("#messageError").hide();
        }


        if ($('[name="recurringEvent"]:checked').val() == "yes") {
            if ($('#durationEvents').val() <= 0 || $('#durationEvents').val() > 4) {
                $("#messageError").text('Duration value of events must be from 1 to 4').show();
                return false;
            }
            else
            {
                $("#messageError").hide();
            }
        }

        if ($('username') == "") {
            $("#messageError").text('You need entry username').show();
            return false;
        }
        else
        {
            $("#messageError").hide();
        }

        var postData = {};
        url = $(this).attr('href');
        postData.eventDate = $('#eventDate').text();
        postData.dateStart = $('#dateStart').val();
        postData.dateEnd = $('#dateEnd').val();
        postData.description = $('#description').val();
        postData.deleteAllEvent = $('input[name="deleteAllEvent"]').prop('checked');
        postData.recurrentId = $('#recurrentId').text();
        postData.id = $('#eventId').text();
        // console.log($('#eventId').val());
        $.ajax({
            type: "POST",
            url: url,
            data: $.param(postData),
            processData: true,
            dataType: 'json',
            error: function (res)
            {

            },
            success: function (res) {
                // console.log(res);

                $("#messageError").text(res.message).show();

                if ($('input[name="deleteAllEvent"]').prop("checked"))
                {
                    $('[recurrentid="' + $('#recurrentId').text() + '"]').text(res.time);
                } else
                {
                    $('[id="' + $('#eventId').text() + '"]').text(res.time);
                }
                $('#eventdetails').hide();
            }

        });
    });

    $('#newevent').submit(function () {
        var hourStart = $('#hourStat').val();
        var minutStart = $('#minutStat').val();
        var hourEnd = $('#hourEnd').val();
        var minutEnd = $('#minutEnd').val();
        if ($('#timePrefStart').val() == "PM") {
            hourStart = hourStart + 12;
        }
        if ($('#timePrefEnd').val() == "PM") {
            hourEnd = hourEnd + 12;
        }
        var hourStartTime = new Date(0, 0, 0, hourStart, minutStart);
        var hourEndTime = new Date(0, 0, 0, hourEnd, minutEnd);

        if (hourStartTime.getTime() > hourEndTime.getTime()) {
            $("#messageError").text('Time start must be lower time end').show();
            return false;
        }
        else
        {
            $("#messageError").hide();
        }

        if ($('[name="recurringEvent"]:checked').val() == "yes") {
            if ($('#durationEvents').val() <= 0 || $('#durationEvents').val() > 4) {
                $("#messageError").text('Duration value of events must be from 1 to 4').show();
                return false;
            }
            else
            {
                $("#messageError").hide();
            }
        }

        if ($('username') == "") {
            $("#messageError").text('You need entry username').show();
            return false;
        }
        else
        {
            $("#messageError").hide();
        }
    });

    $('#delete').on('click', function (event) {
        event.preventDefault();
        var postData = {};
        url = $(this).attr('href');
        postData.recurrentId = $('#recurrentId').text();
        postData.deleteAllEvent = $('input[name="deleteAllEvent"]').prop('checked');
        postData.id = $('#eventId').text();
        console.log($('#eventId').val());
        $.ajax({
            type: "POST",
            url: url,
            data: $.param(postData),
            processData: true,
            dataType: 'json',
            error: function (res)
            {
                $("#messageError").text(res.message).show();
            },
            success: function (res) {
                // console.log(res);
                if (res.success)
                {
                    $("#messageError").text(res.message).show();

                    if ($('input[name="deleteAllEvent"]').prop("checked"))
                    {
                        $('[recurrentid="' + $('#recurrentId').text() + '"]').text("");
                    } else
                    {
                        $('[id="' + $('#eventId').text() + '"]').text("");
                    }
                    $('#eventdetails').hide();
                }
            }
        });

    });
    $('#newuser').submit(function () {
        var createUser = true;
        var message = "";
        //alert(1);
        if ($('#name').val() == "")
        {
            createUser = false;
            message = message + "Enter a name. ";
        }
        if ($('#surname').val() == "")
        {
            createUser = false;
            message = message + "Enter a surname.";
        }
        if ($('#username').val() == "")
        {
            createUser = false;
            message = message + "Enter a username. ";
        }
        if ($('#mail').val() == "")
        {
            createUser = false;
            message = message + "Enter a mail. ";
        }
        if ($('#password').val() == "")
        {
            createUser = false;
            message = message + "Enter a password.";
        }
        if (!createUser) {
            $("#messageError").text(message).show();
            return false;
        }
        else
        {
            $("#messageError").hide();
        }
    });
});

