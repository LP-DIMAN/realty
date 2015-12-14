@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Риэлтор</div>
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
        
			
				
        <div class="row">
            <div class="col-lg-4">
            <h3>Клиенты</h3><br>

            @foreach($clients as $client)
             <div class="table table-bordered">
                <strong>ФИО</strong><br>
                {{$client->surname}} {{$client->name}} {{$client->patronymic}}<br>
                <strong>Предпочтения</strong><br>
                <strong> Контакты </strong><br>
                {{$client->phone}}
               </div>

            @endforeach



            </div>
            <div class="col-lg-4">
            <h3> Рабочий стол </h3>



            </div>
            <div class="col-lg-4">

            <h3> Объявления </h3><br>
            @foreach($adverts as $advert)
             <div class="table table-bordered">
               <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                    {{$advert->description}}<br>
                    <span style="margin-left:721px"><strong>Цена: </strong>{{$advert->price}} рублей</span>
                    <hr>
                    </div>
            @endforeach;

            </div>
        </div><!-- .container-->
   
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
