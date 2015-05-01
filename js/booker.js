
$(document).ready(function () {

    $('html').on('click', function () {
        $('#eventdetails').hide();

    });

    $('#eventdetails').on('click', function (event) {
        event.stopPropagation();
    });

    $('#hourStat').val(function () {
        var hourStart = new Date().getHours();
        $('#minutStat').val(0);
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

    /*$('#hourStat').val(function () {
     var hourStart = new Date().getHours();
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
     
     });*/



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

                $('#dateStart').val(res.date_start);
                $('#dateEnd').val(res.date_end);
                $('#description').val(res.description);
                $('#user').val(res.user);
                $('#dateSubmitted').val(res.dateCreateEvent);
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
//var timeSt = $('#dateStart').val();
        var arrStart = $('#dateStart').val().split(':');
//var hourStartTime = new Date(0, 0, 0, arrSt[0], arrSt[1]);
        var arrEnd = $('#dateEnd').val().split(':');

        //  $('#dateStart').val()
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

        /*   if ($('[name="recurringEvent"]:checked').val() == "yes") {
         if ($('#durationEvents').val() <= 0 || $('#durationEvents').val() > 4) {
         alert('Duration value of events must be from 1 to 4');
         return false;
         }
         }*/
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
        postData.dateEnd = $('#dateEnd').val();
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
                if (res.success)
                {
                    $('#eventdetails').hide();
                    location.reload();
                }
            }
        });
        // console.log(url);
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

        /*   if ($('[name="recurringEvent"]:checked').val() == "yes") {
         if ($('#durationEvents').val() <= 0 || $('#durationEvents').val() > 4) {
         alert('Duration value of events must be from 1 to 4');
         return false;
         }
         }*/
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
                    $('#eventdetails').hide();
                    setTimeout('location.reload();', 3000);
                }
            }
        });

        //console.log(url);
    });
   /* $('#newuser').submit(function () {
        var createUser = true;
        var message = "";
        if ($('#name').val() == "")
        {
            createUser = false;
            message = message + "Enter a name. ";
        }
        else if ($('#surname').val() == "")
        {
            createUser = false;
            message = message + "Enter a surname.";
        }
        else if ($('#username').val() == "")
        {
            createUser = false;
            message = message + "Enter a username. ";
        }
        else if ($('#mail').val() == "")
        {
            createUser = false;
            message = message + "Enter a mail. ";
        }
        else if ($('#password').val() == "")
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
    });*/
});

