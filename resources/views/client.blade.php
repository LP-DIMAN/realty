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
                   <strong>Риэлтор:</strong> {{$advert->surname}} {{$advert->name}}
                   <!--<form action="edit_advert" method="GET"> -->
                   <input type="hidden" id="id_realtor" value="{{$advert->id_realtor }}">
                  <input type="hidden" id="token" value="{{ csrf_token() }}">
  
                  @if ($advert->comment!==null)
                  

                      <div><strong> Комментарий к записи: </strong> {{$advert->comment}} </div>
                     
                     

                  @endif

                   </div>
                   </div>


                                      
                      @if ($advert->cross_advert == 1 || $advert->lead == 1)


                    

                      <button type="submit" value="{{$advert->id_realty}}" name="comment" class="comment btn btn-primary"> Добавить комментарий</button>
                    <button type="submit" value="{{$advert->id_realty}}" name="link" class='link btn btn-warning'>Поделиться ссылкой</button>
                    <button type="submit" class="delete_advert btn btn-danger" value="{{$advert->id_realty}}" name='delete_advert'> Удалить объявление </button>
                        

                    @else
                    <button type="submit" value="{{$advert->id_realty}}" name="comment" class="comment btn btn-primary"> Добавить комментарий</button>
                    <button type="submit" value="{{$advert->id_realty}}" name="cross" class="cross btn btn-info"> Перечеркнуть </button>
                   <button type="submit" value="{{$advert->id_realty}}" name="lead" class='leadd btn btn-success'>Обвести</button>
                   <button type="submit" value="{{$advert->id_realty}}" name="link" class='link btn btn-warning'>Поделиться ссылкой</button>
                    <button type="submit" class="delete_advert btn btn-danger" value="{{$advert->id_realty}}" name='delete_advert'> Удалить объявление </button>


                      @endif
                    
                   
                   <!--</form> -->
                    </div>
                  
				@endforeach
     
	
	</div>



<div id="calendar"></div>
        <button id="add_event_button">Добавить событие</button>
        <div id="dialog-form" title="Событие">
            <p class="validateTips"></p>
            <form>
                <p><label for="event_type">Тип события</label>
                <input type="text" id="event_type" name="event_type" value=""></p>
                <p><label for="event_start">Начало</label>
                <input type="text" name="event_start" id="event_start"/></p>
                <p><label for="event_end">Конец</label>
                <input type="text" name="event_end" id="event_end"/></p>
                <p><label for="event_realtor">Выбрать риэлтора</label>
                <select name="event_realtor" id="event_realtor" >
                   <option   value="-">-</option>
                  @foreach ($realtor as $r)

                    <option   value="{{$r->id}}">{{$r->surname}} {{$r->name}}</option>

                  @endforeach

                </select>
                </p>
             
                <input type="hidden" name="event_id" id="event_id" value="">
            </form>
        </div>
        </div>

@endsection