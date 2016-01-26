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
         
<input type="search" name="search_clients" class="search_clients" placeholder='Поиск клиентов'>
<button type="submit" name="result_search_clients" class="result_search_clients btn btn-warning btn-sm">Найти</button>
          <div class='clients'>
          <div class="table table-bordered">
            @foreach($clients as $client => $advert)
             <div class="table table-bordered">
             <div class="client_adverts">
             <div class ="client">
                <strong>ФИО</strong><br>
             
                {{$client}} <br>
               
                <strong>Предпочтения</strong><br>
                <p>
                @for($i = 0;$i < count($advert);$i++)

                <input type="hidden" value="{{$advert[$i]['id']}}" name='id_client' class="id_client">
              <!-- Название:{{$advert[$i]['title']}} <br>-->
               Город: {{$advert[$i]['city']}} <br>
                Количество комнат:{{$advert[$i]['quantity_room']}} <br>
              <!-- Описание: {{substr($advert[$i]['description'],0,60)}} <br>-->
               Цена: {{$advert[$i]['price']}}

                </p>
               
                @endfor
               
                </div>
                </div>
                </div>
            @endforeach
            </div>
              
            </div>
            
            </div>
            <div class="col-lg-4">
            <h3> Рабочий стол </h3>
            <div class="desctop"><hr>
          </div>
            
            <div class='desctop_adverts'>


            </div>        

                
            <button type="submit" name="save_changes" class='btn btn-success'>Сохранить изменения</button>
            </div>
            <div class="col-lg-4">
            
            <h3> Объявления </h3><br>
            
            <input type="search" name="search_adverts_realtor" class="search_adverts_realtor" placeholder='Поиск объявлений по названию и цене'>
            <button type="submit" name="result_search_adverts_realtor" class="result_search_adverts_realtor btn btn-warning btn-sm">Найти</button>
        <div class="realtor_adverts">
            @foreach($adverts as $advert)
             <div class="table table-bordered">
             <div class="adverts_realtor">
               <input type="hidden" value="{{$advert->id_realty}}" name="id_advert[]" class="id_advert">
               <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                    {{substr($advert->description,0,60)}}...<br>
                    <span ><strong>Цена: </strong>{{$advert->price}} рублей</span>
                    <hr>
                    </div>
            @endforeach
            </div>
            </div>
            </div>
            </div>
        </div><!-- .container-->
 
				</div>
                 
			</div>
		</div>

	</div>
     <div id="calendar1"></div>
</div>
@endsection
