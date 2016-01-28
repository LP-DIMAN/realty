@extends('app')
<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
<div id="wowslider-container1">
<div class="ws_images"><ul>
        <li><img src="data1/images/03.jpg" alt="дом" title="дом" id="wows1_0"/></li>
        <li><img src="data1/images/20140207_1901517.jpg" alt="дом" title="дом" id="wows1_1"/></li>
        <li><img src="data1/images/24147.jpg" alt="дом" title="дом" id="wows1_2"/></li>
        <li><img src="data1/images/domzkurpucha.jpg" alt="дом" title="дом" id="wows1_3"/></li>
        <li><img src="data1/images/home1600x900001.jpg" alt="дом" title="дом" id="wows1_4"/></li>
        <li><img src="data1/images/houses_in_the_alps_6.jpg" alt="дом" title="дом" id="wows1_5"/></li>
        <li><img src="data1/images/kartinki24_home_0085.jpg" alt="дом" title="дом" id="wows1_6"/></li>
        <li><img src="data1/images/komw_architektura_01.jpg" alt="дом" title="дом" id="wows1_7"/></li>
        <li><img src="data1/images/rsz_0_b48fc_a2daad04_xxl.jpg" alt="дом" title="дом" id="wows1_8"/></li>
        <li><a href="http://wowslider.com"><img src="data1/images/world___india_beautiful_houses_in_goa_066066_.jpg" alt="дом" title="дом" id="wows1_9"/></a></li>
        <li><img src="data1/images/_3.jpg" alt="красивые дома3" title="красивые дома3" id="wows1_10"/></li>
    </ul></div>

</div>  
<!-- END WOW-->
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
                    <strong class='options_search'>Параметры поиска:</strong>
                    <form id='search'>
                    
                        <select name="type" id="type" class="form-control type_realty options_search">
                            <option class='options_search' value="Дом">Дом</option>
                            <option class='options_search' value="Квартира">Квартира</option>
                            <option class='options_search' value="Участок">Участок</option>

                        </select>
                        <strong class='options_search'>Город:</strong> <input type="text" name="city" id="city" class="form-control">
               

                    
                        <input type="checkbox" name='new' id='new'><label for="new">Новое жилье</label><br>
                        <strong class='options_search'>Количество комнат: </strong> <br>
                            
                             <strong class='options_search'>От </strong> <input type="number" name="min_rooms" id='min_rooms' min='0' max='21' value="0">
                             <strong class='options_search'>До</strong> <input type="number" name="max_rooms" id='max_rooms' min='0' max='21' value="10"><br>
                                <label for="minCost">Цена:</label><br>

<strong class='options_search'>От </strong> <input type="number" id="minCost" name="min_price" value="50000000 " min='0'/>

<strong class='options_search'>До </strong> <input type="number" id="maxCost" name="max_price" min='0'  value="100000000 "/>&nbsp;<strong class='options_search'>рублей</strong><br>

<div id="slider"></div><br>

                         <button type="button" id="search_adverts" class="btn btn-success">Показать объявления</button>
                    
                    </form>
                    <div id="result"></div>


                </div>
       
                <div class="row">


                    @if (!Auth::guest() && $recommended_adverts !=null)
                    <div class="recommended_adverts">

                     <strong class='recommended_title'>Рекомендованные объявления</strong> 
            @foreach($recommended_adverts as $advert)
             <div class="table table-bordered">
             <div class="recomended_realtor">
              Объявление добавлено <em> {{$advert->date}} </em> <br>
                    @if ($advert->image !==null)
                     <img src='{{$advert->image}}' class="image_avatar img-responsive img-rounded" id='resizable'><br>
                     @endif
               <strong class='title_advert'>{{$advert->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$advert->type}}<br>
                    <strong>Количество комнат: </strong>{{$advert->quantity_room}}<br>
                    <strong>Город: </strong>{{$advert->city}}<br>
                    {{$advert->description}}<br>
                    
                    <span ><strong>Цена: </strong>{{$advert->price}} рублей</span><br>
                     @if (Auth::user()->id_role == 2 && App\Adverts::check_advert(Auth::user()->id,$advert->id_realty) == null )
                
                    
                        <button type="submit"  value="{{$advert->id_realty}}" name="remember" class="remember btn btn-info"> Запомнить </button><br>
                   
                         @elseif (Auth::user()->id_role == 2 && App\Adverts::check_advert(Auth::user()->id,$advert->id_realty))
                
                    
                        <button type="submit"  value="{{$advert->id_realty}}" name="remember" class="remember btn btn-primary" disabled='disabled'> Уже связывался </button><br>
                        @endif
                    <hr>
                    </div>
                    </div>
            @endforeach
            

                    

                    @endif

                    </div><hr>


                    @foreach ($adverts as $advert)
                    <div class='advert col-xs-12'>
                    <div class="table table-bordered">
                    Объявление добавлено <em> {{$advert->date}} </em> <br>
                    @if ($advert->image !==null)
                     <img src='{{$advert->image}}'  class="image_avatar img-responsive img-rounded" id='resizable'><br>
                     @endif
                    <strong class='title_advert'>{{$advert->title}}</strong><br>
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
                  
                    <span class='col-md-offset-9'><strong>Цена: </strong>{{$advert->price}} рублей</span>
                    @if ($advert->new == 1)
                    <img src='/images/new.png' width="100">
                   @endif
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
