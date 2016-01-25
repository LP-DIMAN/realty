@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Админ</div>
				@if (Session::has('admin'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('admin') }}
                     </div>
                </div>
            </div>
        @endif
@if (Session::has('realtor_success'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('realtor_success') }}
                     </div>
                </div>
            </div>
        @endif
        @if (Session::has('realtor_cancel'))
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                     <div class="alert alert-success" role="alert">                   
                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
                             <span aria-hidden="true">×</span>                   
                         </button>
                         {{ Session::get('realtor_cancel') }}
                     </div>
                </div>
            </div>
        @endif
				
				<div class="panel-body">
		 	<form action="admin_suc" method="get">
					@foreach($admin as $administrator)

 			<strong>{{$administrator->name}} {{$administrator->surname}}</strong> просит разрешения стать риэлтором<br>
					<button type="submit" class="btn btn-success" name="success" value="{{$administrator->id}}">Подтвердить </button>
					<button type="submit" class="btn btn-danger" value="{{$administrator->id}}" name="cancel">Отклонить</button><br>
					
					@endforeach
				  @foreach($status_advert as $status)

        
            <div class="row">
                    <div class='advert'>
                    <div class="table table-bordered">
                     @if ($status->image !==null)
                     <img src='{{$status->image}}' width="200" class="image_avatar"><br>
                     @endif
                    <strong>{{$status->title}}</strong><br>
                    <strong>Тип недвижимости: </strong>{{$status->type}}<br>
                    <strong>Количество комнат: </strong>{{$status->quantity_room}}<br>
                    <strong>Город: </strong>{{$status->city}}<br>
                   <div> {{$status->description}}<br> </div>
                    <span style="margin-left:721px"><strong>Цена: </strong>{{$status->price}} рублей</span>
                    <button type="submit" class="btn btn-success" name="success_advert" value="{{$status->id_realty}}">Подтвердить </button>
                    <button type="submit" class="btn btn-danger" value="{{$status->id_realty}}" name="cancel_advert">Отклонить</button><br>
                    </div>
                     </div>
                    </div>
                   
                    
                    @endforeach
                  

					</form>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection