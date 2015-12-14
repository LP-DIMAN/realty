//
// Точка входа.
//

$(document).ready(function(){


$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
	
0
	$('.remember').click(function(){
		 var id_advert = $(this).val();
	$(this).html("<button type='checkbox' disabled='disabled'   name='remember' class='remember'>  Запомнили </button>");
	$.get('true_advert',{remember:id_advert});

 	

	});
	/*$('#send').click(function(){
		 var params = $('#register').serialize();
	
	$.post('auth/register',params);

 	

	});*/


				
$('.comment').click(function(){
		
	var id_comment = $(this).val();

	console.log(id_comment);
	$(this).html("<textarea rows=10 cols=70 name='add_comment' class='add_comment' maxlengh='256' autofocus> </textarea><br><button type='submit' name='add' class='add'> Добавить сообщение</button>");
	
	$('.add').click(function()
	{
		var params = $('.add_comment').val();
		console.log(params);
		$.post('add_comment',{id_advert:id_comment,params},function(data,textStatus,jqXHR)
		{
			$('.add_comment').html(params);
			$('.add').remove();
			
		});
	});

	
	

});
	
	$('.delete_advert').click(function()
	{

		var id_comment = $(this).val();
		console.log(id_comment);
		$.get('delete_advert',{comment:id_comment},function(data,textStatus,jqXHR)
		{

			

			alert('Запись успешно удалена');

		});


	});

	$('.cross').click(function()
	{
	var id_advert = $(this).val();
	console.log(id_advert);


	$(this).siblings('.advert').toggleClass('empty del-cross');
	$(this).siblings('.leadd').remove();
	$(this).remove()
	$.get('cross_advert',{id_advert:id_advert});

	});

	


	$('.leadd').click(function()
	{
	var id_advert = $(this).val();

	console.log(id_advert);

	$(this).siblings('.advert').toggleClass('empty holder');
	$(this).siblings('.cross').remove();
	$(this).remove();
	$.get('lead_advert',{id_advert:id_advert});

	});

	$('.link').click(function()
	{
	var id_comment = $(this).val();

	$(this).html("<br><script type='text/javascript' src='//yastatic.net/es5-shims/0.0.2/es5-shims.min.js' charset='utf-8'></script><script type='text/javascript' src='//yastatic.net/share2/share.js' charset='utf-8'></script><div class='ya-share2' data-services='vkontakte,facebook,odnoklassniki,moimir' data-url='http://realty?id_advert=id_comment'></div>");

	
	

	});

 	 $('#calendar').fullCalendar({

                firstDay: 1,
                height: 500,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                monthNames: ['Январь','Февраль','Март','Апрель','Май','οюнь','οюль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв.','Фев.','Март','Апр.','Май','οюнь','οюль','Авг.','Сент.','Окт.','Ноя.','Дек.'],
                dayNames: ["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],
                dayNamesShort: ["ВС","ПН","ВТ","СР","ЧТ","ПТ","СБ"],
                buttonText: {
                    prev: "<",
                    next: ">",
                    prevYear: "<",
                    nextYear: ">",
                    today: "Сегодня",
                    month: "Месяц",
                    week: "Неделя",
                    day: "День"
                }

            });

	});
