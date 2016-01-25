$(document).ready(function() {
            /* глобальные переменные */
            var event_start = $('#event_start');
            var event_end = $('#event_end');
            var event_type = $('#event_type');
            var calendar = $('#calendar1');
            var form = $('#dialog-form');
            var event_id = $('#event_id');
            var format = "MM/dd/yyyy HH:mm";
            /* кнопка добавления события */
            $('#add_event_button').button().click(function(){
                formOpen('add');
            });
            /** функция очистки формы */
            function emptyForm() {
                event_start.val("");
                event_end.val("");
                event_type.val("");
                event_id.val("");
            }
            /* режимы открытия формы */
            function formOpen(mode) {
                if(mode == 'add') {
                    /* скрываем кнопки Удалить, Изменить и отображаем Добавить*/
                    $('#add').show();
                    $('#edit').hide();
                    $("#delete").button("option", "disabled", true);
                }
                else if(mode == 'edit') {
                    /* скрываем кнопку Добавить, отображаем Изменить и Удалить*/
                    $('#edit').show();
                    $('#add').hide();
                    $("#delete").button("option", "disabled", false);
                }
                form.dialog('open');
            }
            /* инициализируем Datetimepicker */
            event_start.datetimepicker({hourGrid: 4, minuteGrid: 10, dateFormat: 'mm/dd/yy'});
            event_end.datetimepicker({hourGrid: 4, minuteGrid: 10, dateFormat: 'mm/dd/yy'});
            /* инициализируем FullCalendar */
            calendar.fullCalendar({
                firstDay: 1,
                height: 500,
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','Июнь','Июль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                buttonText: {
                    prev: "&nbsp;&#9668;&nbsp;",
                    next: "&nbsp;&#9658;&nbsp;",
                    prevYear: "&nbsp;&lt;&lt;&nbsp;",
                    nextYear: "&nbsp;&gt;&gt;&nbsp;",
                    today: "Сегодня",
                    month: "Месяц",
                    week: "Неделя",
                    day: "День"
                },
                /* формат времени выводимый перед названием события*/
                timeFormat: 'H:mm',
                /* обработчик события клика по определенному дню */
                dayClick: function(date, allDay, jsEvent, view) {
                    var newDate = $.fullCalendar.formatDate(date, format);
                    event_start.val(newDate);
                    event_end.val(newDate);
                    formOpen('add');
                },
                /* обработчик кликак по событияю */
                eventClick: function(calEvent, jsEvent, view) {
                    event_id.val(calEvent.id);
                    event_type.val(calEvent.title);
                    event_start.val($.fullCalendar.formatDate(calEvent.start, format));
                    event_end.val($.fullCalendar.formatDate(calEvent.end, format));
                    formOpen('edit');
                },
                /* источник записей */
                eventSources: [{
                    url: 'realtor_events',
                    type: 'POST',
                    data: {
                        op: 'source'
                    },
                    error: function() {
                        alert('Ошибка соединения с источником данных!');
                    }
                }]
            });
           
    });