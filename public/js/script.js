//
// Точка входа.
//

$(document).ready(function(){
   // Перетаскивание клиентов

    $(".client").draggable(
    	{
    	 cursor:"pointer",
    	 scroll:false,
    	 scope:'client',
    	 snap:true,
    	 snapMode:'inner',
    	

    	 start:function()
    	 {
    	 	$(this).css('background','yellow');
    	 },
    	 stop:function()
    	 {
    	 	$(this).css('background','white');


    	 }
    	 

 });
    //Изменение размера изображений
    $('.image_avatar').resizable(
    {
    	animate:true,
    }

    	);
 

//Перетаскивание объявлений
 $('.realtor_adverts,.desctop_adverts').sortable(
 	{ connectWith: ".work_advert",

 	stop:function(event,ui)
 	{
 		if (!$('.desctop').hasClass('ui-state-highlight'))
 		{
 			event.preventDefault();
 			alert('Сначала перетащите клиента в определенную область');
 		}
 	},

	}).disableSelection();

    

    //обработка клиента
    $(".desctop").droppable({
 	
    	tolerance:'intersect',
    	scope:'client',

      out: function(event, ui) {
        $(this)
          .removeClass("ui-state-highlight");
        $('.client').not(ui.draggable).draggable("option", "revert", null);
        $('.desctop_adverts').empty();
        $('.help').prependTo($(this));
       
      },
      over:function(event,ui)
      {
      	 if ($(this).hasClass("ui-state-highlight")) {
          event.preventDefault();
        // ui.draggable.appendTo('.clients');
          return;
        }

        $('.help').empty();
		     
         $(this)
          .addClass("ui-state-highlight");
          $('.client').not(ui.draggable).draggable("option", "revert", 'valid');
         
   		ui.draggable.prependTo($(this));
   		var client = $('.desctop').find('.id_client').val();
   		$.get('desctop_adverts',{client:client},function(data)
   			{

   				var obj = $.parseJSON(data);
					//console.log(obj.length);
					var result = $('.desctop_adverts');
				
					result.empty();
					
						for(var i = 0; i <obj.length;i++)
						{

							result.append("<div class='adverts_realtor'>" +
						"<input type='hidden' class='id_adv' value=" + obj[i].id_client + ">" +  
						 "Объявление добавлено <em>" + obj[i].date + "</em> <br>" +
                    	"<strong>" + obj[i].title + "</strong><br>" +
                    "<strong>Тип недвижимости: </strong>" + obj[i].type + 
                    "<br><strong>Количество комнат: </strong>" + obj[i].quantity_room + 
                    "<br><strong>Город: </strong>" + obj[i].city + 
                   "<br><strong> Описание: </strong><br>" + obj[i].description.substring(0,60) + "..."  + 
             
                  
               	"<br><span><strong>Цена: </strong>" + obj[i].price + " рублей</span>"+
				"<br> <button type='submit' class='btn btn-danger'  name='delete_recommended_advert' id="+ obj[i].id_realty  + " value=" + obj[i].id_realty  + ">Удалить </button></div><br /> " );

						}
					 result.html();
					 $('.desctop_adverts .adverts_realtor').draggable();
					 $('[name="delete_recommended_advert"]').click(function(){

				var id_advert = $(this).val();
				var id_client = $(this).siblings('.id_adv').val();

				$(this).parent('.adverts_realtor').fadeOut(300);
				$.get('delete_recommended_advert',{id_advert:id_advert,id_client:id_client});


			});
					//Удаление повторяющихся объявлений
			$('.desctop_adverts .adverts_realtor [name=delete_recommended_advert] ').each(function (index, elem) {
        var id_advert = elem;

        $('.realtor_adverts .adverts_realtor').each(function (index, elem) {
            var id_realtor_advert = elem;
         	
            if (id_realtor_advert.id == id_advert.id) {
                id_realtor_advert.remove();
            };
        });
    });
   			});
			
      }
    });


  /*  $(".desctop_adverts").droppable({
    
      out: function(event, ui) {
   var count_adverts = [];

     $('.desctop_adverts').find('.id_adv').each(function(index, element){count_adverts.push($(element).val())}); 
       $('.adverts_realtor').draggable("option", "appendTo", 'body');
      console.log(count_adverts);
      }
    });*/
    

//Сохранение изменений
$('[name="save_changes"]').click(function()
{


var client = $('.desctop').find('.id_client').val();


var count_adverts = $('.desctop_adverts').find($('.id_advert')).serialize();

var result = 'client=' + client + '&' +  count_adverts;

$.get('save_changes',result,function(data)
	{
		alert('Изменения сохранены');
	});
});


// Настройки ajax 
$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
	
// Запомнить объявление
	$('.remember').click(function(){
		 var id_advert = $(this).val();
		 $(this).attr('disabled','disabled');
	$(this).html("<button type='checkbox' disabled='disabled'   name='remember' class='remember btn btn-info'>  Запомнили </button>");
	$.get('true_advert',{remember:id_advert});

 	

	});
	/*$('#send').click(function(){
		 var params = $('#register').serialize();
	
	$.post('auth/register',params);

 	

	});*/

// Добавление комментариев
				
$('.comment').click(function(){
		
	var id_comment = $(this).val();

	
	
	$(this).next('.empty_comment').html("<br><textarea rows=10 cols=70 name='add_comment' class='add_comment btn btn-primary' maxlengh='256' autofocus> </textarea><br><button type='submit' name='add' class='add btn btn-primary'> Добавить сообщение</button>");
	
	$('.add').click(function()
	{
		var params = $('.add_comment').val();
		
		$.post('add_comment',{id_advert:id_comment,params},function(data,textStatus,jqXHR)
		{
			$('.comment_post').html('<strong>Комментарий к записи: </strong>' + params);
			$('.add').remove();
			$('.add_comment').remove();
			
		});
	});

	
	

});
	

	//Удаление объявления из личного кабинета
	$('.delete_advert').click(function()
	{	
			var delete_advert = $(this);
			var id_comment = $(this).val();
		$( "#dialog-delete" ).dialog({
      resizable: false,
      height:200,
      modal: true,
      buttons: {
        "Да": function() {
          $( this ).dialog( "close" );

		console.log(id_comment);
				
		delete_advert.parent().fadeOut(300);
		
		$.get('delete_advert',{comment:id_comment});
        },
        'Нет': function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
		
	});

//Перечеркивание неважных для клиента объявлений
	$('.cross').click(function()
	{
	var id_advert = $(this).val();
	console.log(id_advert);


	$(this).siblings('.advert').toggleClass('del-cross');
	//$(this).siblings('.leadd').remove();
	//$(this).remove()
	if ($(this).siblings('.advert').hasClass('del-cross')){
	$.get('cross_advert',{id_advert:id_advert});
}
else
{
	$.get('delete_cross_advert',{id_advert:id_advert});
}

	});

	

//Обведение важных для клиента объявлений
	$('.leadd').click(function()
	{
	var id_advert = $(this).val();

	console.log(id_advert);

	$(this).siblings('.advert').toggleClass('holder');
	//$(this).siblings('.cross').remove();
	//$(this).remove();
	
	

	if ($(this).siblings('.advert').hasClass('holder')){
	$.get('lead_advert',{id_advert:id_advert});
}else{
	$.get('delete_lead_advert',{id_advert:id_advert});
}

	});




// Поделиться ссылкой на объявление
	$('.link').click(function()
	{
	var id_comment = $(this).val();

	$(this).html("<br><script type='text/javascript' src='//yastatic.net/es5-shims/0.0.2/es5-shims.min.js' charset='utf-8'></script><script type='text/javascript' src='//yastatic.net/share2/share.js' charset='utf-8'></script><div class='ya-share2' data-services='vkontakte,facebook,odnoklassniki,moimir' data-url='http://realty?id_advert=" + id_comment + "'></div>");

	
	

	});
		//Цена
 	 $("#slider").slider({
	min: 0,
	max: 100000000,
	values: [0,100000000],
	range: true,
	stop: function(event, ui) {
		$("input#minCost").val($("#slider").slider("values",0));
		$("input#maxCost").val($("#slider").slider("values",1));
    },
    slide: function(event, ui){
		$("input#minCost").val($("#slider").slider("values",0));
		$("input#maxCost").val($("#slider").slider("values",1));
    }

});

$("input#minCost").change(function(){
	var value1=$("input#minCost").val()  ;
	var value2=$("input#maxCost").val();

    if(parseInt(value1) > parseInt(value2)){
		value1 = value2;
		$("input#minCost").val(value1);
	}
	$("#slider").slider("values",0,value1);	
});

	
$("input#maxCost").change(function(){
	var value1=$("input#minCost").val();
	var value2=$("input#maxCost").val();
	
	if (value2 > 100000000) { value2 = 100000000; $("input#maxCost").val(100000000)}

	if(parseInt(value1) > parseInt(value2)){
		value2 = value1;
		$("input#maxCost").val(value2);
	}
	$("#slider").slider("values",1,value2);
});


    //Новое жилье, галочка
    $( "#new" ).button();

    //Поиск объявлений по параметрам

    $('#search_adverts').click(function()
	{
		var params = $('#search').serialize();
     $.post('search_adverts',params,function(data)
     {

     	$('.advert').remove();
     	if (data == '')
     	{
     		$('#result').html("<strong class='search_result'>Ничего не найдено</strong>");
     	}
     	else{
     	$('#result').html(data);
     }
     	var advert = $('#result .advert').length;
     
     	$('#search_adverts').html('Найденных объявлений - ' + advert);
     })

    });

//Снятие с публикации объявления
	$('.unpublished').click(function()
	{

		var advert = $(this).val();

		$(this).parent().fadeOut(300);
		$.get('unpublished',{unpublished_advert:advert});


	});

	// Удалить мое объявление
	$('.delete_my_advert').click(function()
	{

		var advert = $(this).val();

		$(this).parent().fadeOut(300);
		$.get('delete_my_advert',{delete_my_advert:advert});


	});
		// Редактировать мое объявление
	$('.edit_my_advert').click(function()
	{

		var advert = $(this).val();

		$('strong').replaceWith('textarea');
		//$.get('delete_my_advert',{delete_my_advert:advert});


	});
	//Общий поиск по сайту
	$('.result_all_search').click(function()
	{
		var param = $('.all_search').serialize();
		

	   
		$.post('result_all_search',param,function(data)
			{
					

					var obj = $.parseJSON(data);
					//console.log(obj);
					var result = $('.panel-body');
					result.empty();
					
					result.append('<h1>Результаты поиска </h1>');
					if (obj == '')
					{
						result.html("<strong class='search_result'>Ничего не найдено </strong>");
					}
						for(var i = 0; i < obj.length;i++)
						{

							result.append("<div class='advert'> <div class='table table-bordered'>" +
							
						 "Объявление добавлено <em>" + obj[i].date + "</em> <br>" +
                    	"<strong>" + obj[i].title + "</strong><br>" +
                    "<strong>Тип недвижимости: </strong>" + obj[i].type + 
                    "<br><strong>Количество комнат: </strong>" + obj[i].quantity_room + 
                    "<br><strong>Город: </strong>" + obj[i].city + 
                   "<br><strong> Описание: </strong><br>" + obj[i].description  + 
             
                  
               	"<br><span class='col-md-offset-9'><strong>Цена: </strong>" + obj[i].price + " рублей</span>"+
				"</div> </div><br />" );

						}
					 result.html();
							

						
				
				


			});


	});
//Поиск по клиентам
	$('.result_search_clients').click(function()
	{
		var param = $('.search_clients').serialize();
		

	   
		$.post('result_search_clients',param,function(data)
			{
					

					var obj = $.parseJSON(data);
					//console.log(obj.length);
					var result = $('.clients');
					result.remove();
					var search_client = $('.search_client');
					search_client.empty();
					$('.client').remove();
					search_client.addClass('work_advert');
					keys = Object.keys(obj)
					
						for(var i = 0,l1 = keys.length; i < l1;i++)
						{
								
							 search_client.prepend(keys[i] + 
							 	"<br><strong> Предпочтения </strong><br>"); 

    						for (var j = 0, arr = obj[keys[i]], l2 = arr.length; j < l2; j++) {
								
							search_client.append("<div class='client'><input type='hidden' value=" + arr[j].id + " name='id_client' class='id_client'>" +
						"<strong>" + arr[j].title + "</strong><br>" +
                    "Тип недвижимости:" + arr[j].type + 
                    "<br>Город:" + arr[j].city + 
                    "<br>Город:" + arr[j].quantity_room + 
                    "<br><span>Цена:" + arr[j].price + " рублей</span>"+
				"</div><br />" );

						}
						
					
					};
					
					 search_client.html();


				});
				


				});

//Автодополнение объявлений при поиске
$( ".search_adverts_realtor" ).autocomplete({
      source: 'autocomplete_adverts',
      minLength:2
    });
//Автодополнение при поиске клиетов по их предпочтениям
$( ".search_clients" ).autocomplete({
      source: 'autocomplete_clients',
      minLength:2
    });


			//Поиск объявлений риэлтора 
		$('.result_search_adverts_realtor').click(function()
	{
		var param = $('.search_adverts_realtor').serialize();
		

	   
		$.post('result_search_adverts_realtor',param,function(data)
			{
					

					var obj = $.parseJSON(data);
					//console.log(obj.length);
					var result = $('.realtor_adverts');
					result.empty();
					
						for(var i = 0; i <obj.length;i++)
						{

							result.append("<div class='table table-bordered'><div class='adverts_realtor'>"  +
						
						 "Объявление добавлено <em>" + obj[i].date + "</em> <br>" +
						  "<input type='hidden' value=" + obj[i].id_realty + " name='id_advert[]' class='id_advert'>" +
                    	"<strong>" + obj[i].title + "</strong><br>" +
                    "<strong>Тип недвижимости: </strong>" + obj[i].type + 
                    "<br><strong>Количество комнат: </strong>" + obj[i].quantity_room + 
                    "<br><strong>Город: </strong>" + obj[i].city + 
                   "<br><strong> Описание: </strong><br>" + obj[i].description.substring(0,60)  + 
             
                  
               	"<br><span><strong>Цена: </strong>" + obj[i].price + " рублей</span>"+
				"</div> </div><br />" );

						}
					 result.html();
	
	// Перетаскивание объявлений
 $('.realtor_adverts,.desctop_adverts').sortable(
 	{ connectWith: ".work_advert",

 	stop:function(event,ui)
 	{
 		if (!$('.desctop').hasClass('ui-state-highlight'))
 		{
 			event.preventDefault();
 			alert('Сначала перетащите клиента в определенную область');
 		}
 	},

	}).disableSelection();
				});


				});

		});
