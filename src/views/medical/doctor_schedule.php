<html>

<head>
    <title>Fullcalendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
</head>

<body>
<div class="container">
        <div class="topnav">
            <a href="quiSommesNous.php">Qui sommes-nous?</a>
            <a href="Presentation.php">Presenter</a>
            <a href="carte.php">Contact</a>
            <a href="personne.php">Se Connecter</a>
            <a href="lien.php">Creer un rendez_vous</a>
            <a class="active"href="planningmedecin.php">Planning</a>
            <a href="centre.php">Liste des centres</a>
        </div>
    <h2>
        <center>Javascript Fullcalendar</center>
    </h2>
    <div class="container">
        <div id="calendar"></div>
    </div>
    <br>
</body>

</html>
<script>
   $(document).ready(function() {
        $('#calendar').fullCalendar({
        selectable: true,
        selectHelper: true,
        select: function () 
        {
            $('#myModal').modal('toggle');
        },

        header: 
        {
            left: 'month, agendaWeek, agendaDay, list',
            center:'title',
            right:'prev, today , next', 
        },
        buttonText:
        {
            today : 'TODAY',
            month : 'Month',
            week: 'Week',
            day: 'Day',
            list:'List',
        },
        events:[{
            title : 'Mehndi',
            start : '2023-02-01T09:00',
            end : '2023-02-01T13:00',
            color: 'yellow',
            textColor: 'black',
        },
        {
            title:'Haldi',
            start:'2023-02-02T15:00',
            end :'2023-02-02T17:00',
            color: 'yellow',
            textColor: 'black',
        },
        {
            title:'Inscriptions',
            start:'2024-12-02T10:00',
            end :'2024-12-02T12:00',
            color: 'yellow',
            textColor: 'black',
        },
        {
            title:'Mariage',
            start:'2024-02-01T24:00',
            end:'2024-02-02T18:00',
            color: 'yellow',
            textColor: 'black',
            }],
            dayRender:function (date,cell)
            {
                var newdate = $.fullCalendar.formatDate(date,'DD-MM-YYYY');
                if(newdate=='24-05-2023')
                {
                    cell.css("background","yellow");
                }
                else if (newdate =='20-02-2023')
                {
                    cell.css("background",'red') 
                }
                
            },
        });
     });
</script>



<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog"></div>

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Event</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form control"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    


</div>
