
$(document).ready(function () {

    $('#bookIt').on('click', function () {
        alert(a = 1);
    });

    $('#month').on('click', function () {
        $('#meetingSpecText').append('text');
    });

    $('html').on('click', function () {
        $('#eventdetails').hide();
        
    });
    
    $('#eventdetails').on('click', function (event) {
        event.stopPropagation();
    });
    
    
    
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
           // dataType: 'json',
            error: function (res)
            {
                //ТУТ ЧТОТ ДЕЛАЕМ ЕСЛИ СЕРВЕР ВЕРНУЛ ОШИБКУ
            },
            success: function (res) {
                     /*9   console.log(event);
                $('#dateStart').val(res.date_start);
                $('#dateEnd').val(res.date_end);
                $('#description').val(res.description);
                $('#user').val(res.user);
                $('#dateSubmitted').val(res.dateCreateEvent);
                $('#eventdetails').show();*/
            }
        });

        console.log(url);
        //alert('aee');

        // $('#meetingSpecText').append('text');
    });


});

