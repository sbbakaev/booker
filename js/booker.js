
$(document).ready(function () {

    $('#bookIt').on('click', function () {
       // alert(a = 1);
    });

    /*  $('#month').on('click', function () {
     $('#meetingSpecText').append('text');
     });*/

    $('html').on('click', function () {
        $('#eventdetails').hide();

    });

    $('#eventdetails').on('click', function (event) {
        event.stopPropagation();
    });

    $('#hourStat').val(function () {
        var hourStart = new Date().getHours();
        $('#minutStat').val(new Date().getMinutes());
        if (hourStart > 12)
        {
            $('#timePrefStart').val("PM")
            hourStart = hourStart - 12;
            // alert(hourStart);
            return hourStart;
        }
        else {
            $('#timePrefStart').val("AM");
            return hourStart;
        }

    });

    $('#hourEnd').val(function () {
        var hourEnd = new Date().getHours();
        $('#minutEnd').val(new Date().getMinutes());
        if (hourEnd > 12)
        {
            $('#timePrefEnd').val("PM")
            hourEnd = hourEnd - 12;
            // alert(hourStart);
            return hourEnd;
        }
        else {
            $('#timePrefEnd').val("AM");
            return hourEnd;
        }

    });

    $('#hourStat').val(function () {
        var hourStart = new Date().getHours();
        if (hourStart > 12)
        {
            $('#timePrefStart').val("PM")
            hourStart = hourStart - 12;
            // alert(hourStart);
            return hourStart;
        }
        else {
            $('#timePrefStart').val("AM");
            return hourStart;
        }

    });



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
            type: "GET", //тут тип запрос (GET,POST,PUT,DELETE)
            url: url, //тут урл запроса
            dataType: 'json',
            error: function (res)
            {
                //ТУТ ЧТОТ ДЕЛАЕМ ЕСЛИ СЕРВЕР ВЕРНУЛ ОШИБКУ
            },
            success: function (res) {
                //         console.log(res[0]);
//console.log(res[0].date_start);
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

        console.log(url);
        //alert('aee');

        // $('#meetingSpecText').append('text');
    });

    $('#update').on('click', function (event) {
        event.preventDefault();
        var postData = {};
        url = $(this).attr('href');
        postData.eventDate = $('#eventDate').text();
        postData.dateStart = $('#dateStart').val();
        postData.dateEnd = $('#dateEnd').val();
        postData.description = $('#description').val();
        postData.dateEnd = $('#dateEnd').val();
        postData.id = $('#eventId').text();
        //$.param(postData);
        // alert($('#eventId').text());
        console.log($('#eventId').val());
        $.ajax({
            type: "POST", //тут тип запрос (GET,POST,PUT,DELETE)
            url: url, //тут урл запроса
            data: $.param(postData),
            processData: true,
            dataType: 'json',
            error: function (res)
            {
                //ТУТ ЧТОТ ДЕЛАЕМ ЕСЛИ СЕРВЕР ВЕРНУЛ ОШИБКУ
            },
            success: function (res) {
                console.log(res);
                if (res.success)
                {
                    $('#eventdetails').hide();
                }
            }
        });
        console.log(url);
    });

    $('#newevent').submit(function () {
        if($('[name="recurringEvent"]:checked').val()=="yes"){
            if ($('#durationEvents').val() <= 0 || $('#durationEvents').val() > 4) {
                $("#durationError").text('Duration value of events must be from 1 to 4').show();
                return false;
            }
            else
            {
                $("#durationError").hide();
            }
        }
    });

    $('#delete').on('click', function (event) {
        event.preventDefault();
        var postData = {};
        url = $(this).attr('href');
        /*    postData.eventDate = $('#eventDate').text();
         postData.dateStart = $('#dateStart').val();
         postData.dateEnd = $('#dateEnd').val();*/
        postData.recurrentId = $('#recurrentId').text();
        postData.deleteAllEvent = $('input[name="deleteAllEvent"]').prop('checked');
        //alert($('input[name="deleteAllEvent"]').prop('checked'));
        postData.id = $('#eventId').text();
        //$.param(postData);
        // alert($('#eventId').text());
        console.log($('#eventId').val());
        $.ajax({
            type: "POST", //тут тип запрос (GET,POST,PUT,DELETE)
            url: url, //тут урл запроса
            data: $.param(postData),
            processData: true,
            dataType: 'json',
            error: function (res)
            {
                //ТУТ ЧТОТ ДЕЛАЕМ ЕСЛИ СЕРВЕР ВЕРНУЛ ОШИБКУ
            },
            success: function (res) {
                console.log(res);
                if (res.success)
                {
                    $('#eventdetails').hide();
                }
            }
        });

        console.log(url);
        //alert('aee');

        // $('#meetingSpecText').append('text');
    });
});

