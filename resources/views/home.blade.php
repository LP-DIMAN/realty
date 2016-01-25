@extends('app')

@section('content')
<div id='all_search'>
<input type="search" name="all_search" class="all_search" placeholder='Поиск по сайту'>
<button type="submit" name="result_all_search" class="result_all_search btn btn-default btn-sm">Найти</button>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Главная</div>
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
         @if (Session::has('error_realtor'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-danger" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('error_realtor') }}
                     </div>
                </div>
            </div>
        @endif

         @if (Session::has('client'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('client') }}
                     </div>
                </div>
            </div>

        @endif


                <div class="panel-body">
                <div class="search">
                    Параметры поиска:
                    <form id='search'>
                    
                        <select name="type" id="type">
                            <option value="Дом">Дом</option>
                            <option value="Квартира">Квартира</option>
                            <option value="Участок">Участок</option>

                        </select>
                        Город: <input type="text" name="city" id="city"><br>
               

                    
                        <input type="checkbox" name='new' id='new'><label for="new">Новое жилье</label><br>
                        Количество комнат: <br>
                            
                             От <input type="number" name="min_rooms" min='0' value="0">
                             До <input type="number" name="max_rooms" max='21' value="10"><br>
                                <label for="minCost">Цена:</label><br>

От <input type="text" id="minCost" name="min_price" value="50000000 " min='0'/>

До <input type="text" id="maxCost" name="max_price" value="100000000 "/>рублей<br>

<div id="slider"></div>

                         <button type="button" id="search_adverts" class="btn btn-success">Показать объяления</button>
                    
                    </form>
                    <div id="result"></div>


                </div>
       
                <div class="row">


                    @if (!Auth::guest() && $recommended_adverts !=null)
                    <div class="recommended_adverts">

                     <strong class='recommended_title'>Рекомендованные объявления</strong> 
            @foreach($recommended_adverts as $advert)
             <div class="table table-bordered">
             <div class="adverts_realtor">
              Объявление добавлено <em> {{$advert->date}} </em> <br>
                    @if ($advert->image !==null)
                     <img src='{{$advert->image}}' width="200" class="image_avatar"><br>
                     @endif
               <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                    {{$advert->description}}<br>
                    
                    <span ><strong>Цена: </strong>{{$advert->price}} рублей</span>
                    <hr>
                    </div>
                    </div>
            @endforeach
            

                    

                    @endif

                    </div><hr>


                    @foreach ($adverts as $advert)
                    <div class='advert'>
                    <div class="table table-bordered">
                    Объявление добавлено <em> {{$advert->date}} </em> <br>
                    @if ($advert->image !==null)
                     <img src='{{$advert->image}}' width="300" class="image_avatar"><br>
                     @endif
                    <strong>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                   <strong class='description'> Описание: </strong> {{$advert->description}}<br>
                    @if (!Auth::guest())
                    <strong> Телефон: </strong>{{$advert->phone}}<br>
                    <strong> Риэлтор: </strong>{{$advert->surname}} {{$advert->name}}<br>
                  @endif
                    @if (Auth::guest())
                 <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-danger" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                        Чтобы получить контакты риэлтора, Вам нужно авторизоваться
                     </div>
                </div>
            </div>
   
             
                   @elseif (Auth::user()->id_role == 2 && App\Adverts::check_advert(Auth::user()->id,$advert->id_realty) == null )
                
                    
                        <button type="submit"  value="{{$advert->id_realty}}" name="remember" class="remember btn btn-info"> Запомнить </button><br>
                   
                         @elseif (Auth::user()->id_role == 2 && App\Adverts::check_advert(Auth::user()->id,$advert->id_realty))
                
                    
                        <button type="submit"  value="{{$advert->id_realty}}" name="remember" class="remember btn btn-primary" disabled='disabled'> Уже связывался </button><br>
                        @elseif (Auth::user()->id_role == 1)
                    <button type="submit" value="{{$advert->id_realty}}" name="unpublished" class="unpublished btn btn-danger">Снять с публикации</button><br>
            
                        @endif
                  
                    <span style="margin-left:721px"><strong>Цена: </strong>{{$advert->price}} рублей</span>
                    </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
