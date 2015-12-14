@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Личный кабинет клиента</div>
				


				<div class="panel-body">

				@foreach ($remember_adverts_client as $advert)

					<div class="table table-bordered">
          <div class='advert'>
                
   @if ($advert->lead == 1)

             <div class='holder'>

             

         @elseif ($advert->cross_advert == 1)

             <div class='del-cross'>

             @else
                 <div class='empty'>
                   @endif


                    Объявление добавлено <em> {{$advert->date}} </em> <br>
                    <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                   <strong> Описание: </strong> {{$advert->description}}<br>
                   <strong> Телефон: </strong>{{$advert->phone}}<br>
                   <!--<form action="edit_advert" method="GET"> -->
                  <input type="hidden" id="token" value="{{ csrf_token() }}">
  
                  @if ($advert->comment!==null)
                  

                      <div>    <strong> Комментарий к записи: </strong> {{$advert->comment}} </div>
                     
                     

                  @endif

                   </div>
                   </div>


                                      
                      @if ($advert->cross_advert == 1 || $advert->lead == 1)


                    

                      <button type="submit" value="{{$advert->id_realty}}" name="comment" class="comment"> Добавить комментарий</button>
                    <button type="submit" value="{{$advert->id_realty}}" name="link" class='link'>Поделиться ссылкой</button>
                    <button type="submit" class="delete_advert" value="{{$advert->id_realty}}" name='delete_advert'> Удалить объявление </button>
                        

                    @else
                    <button type="submit" value="{{$advert->id_realty}}" name="comment" class="comment"> Добавить комментарий</button>
                    <button type="submit" value="{{$advert->id_realty}}" name="cross" class="cross"> Перечеркнуть </button>
                   <button type="submit" value="{{$advert->id_realty}}" name="lead" class='leadd'>Обвести</button>
                   <button type="submit" value="{{$advert->id_realty}}" name="link" class='link'>Поделиться ссылкой</button>
                    <button type="submit" class="delete_advert" value="{{$advert->id_realty}}" name='delete_advert'> Удалить объявление </button>


                      @endif
                    
                   
                   <!--</form> -->
                    </div>
                  
				@endforeach
     
	
	</div>
</div>
    <div id="calendar"></div>


@endsection