@extends('app')

@section('content')
<div class="container">

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Мои объявления</div>
				 @if (Session::has('message'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('message') }}
                     </div>
                </div>
            </div>
        @endif
         @if (Session::has('advert'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('advert') }}
                     </div>
                </div>
            </div>
        @endif
				


				<div class="panel-body">


					 @foreach ($adverts as $advert)
                    <div class='advert'>
                    <div class="table table-bordered">
                    Объявление добавлено <em> {{$advert->date}} </em> <br>
                    @if ($advert->image !==null)
                     <img src='{{$advert->image}}' width="200" class="image_avatar"><br>
                     @endif
                    <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                   <strong class='description'> Описание: </strong> {{$advert->description}}<br>
                  
                   <strong> Цена: </strong> {{$advert->price}}<br>
                   @if($advert->status == 0)
					<strong class='red'> Неподтвержденное объявление </strong>
                   @endif
                      @if($advert->status == 1)
          <strong class='green'> Подтвержденное объявление </strong><br>
                   @endif
                    <button type="submit"  value="{{$advert->id_realty}}" name="delete_my_advert" class="delete_my_advert btn btn-danger"> Удалить </button><br>
                 
                   </div>
                   </div>
                   @endforeach
                   </div>

                   @endsection