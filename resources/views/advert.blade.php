@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Создание объявления</div>
				<div class="panel-body">
			@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Упс!</strong> Ошибки.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
								
			@if (Session::has('error_advert'))
			            <div class="row">
			                <div class="col-md-8 col-md-offset-2">
			                     <div class="alert alert-danger" role="alert">                   
			                         <button class="close" aria-label="Close" data-dismiss="alert" type="button">                       
			                             <span aria-hidden="true">×</span>                   
			                         </button>
			                         {{ Session::get('error_advert') }}
			                     </div>
			                </div>
			            </div>
			        @endif
				<form class="form-horizontal" role="form" method="POST" action="adverts" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">Наименование</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="title" value="{{ old('title') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Тип жилья</label>
							<div class="col-md-4">
								Дом      <input type="radio" name="type_realty" value="дом">
								Квартира <input type="radio"  name="type_realty" value="квартира">
								Участок <input  type="radio"   name="type_realty" value="участок">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Город</label>
							<div class="col-md-6">
							<input name="city" id="city">
                         
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Количество комнат</label>
							<div class="col-md-6">
								<select name="room" id="room">
									@for ($i=0;$i<=15;$i++)
									<option value="{{$i}}">{{$i}}</option>
									@endfor
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Цена</label>
							<div class="col-md-6">
								<input type="number" class="form-control" name="price" value="{{ old('price') }}" min='0' max='100000000' placeholder="в рублях">
							</div>
						</div>

						
						<div class="form-group">
							<label class="col-md-4 control-label">Новое жилье</label>
							<div class="col-md-1">
								<input type="checkbox" class="form-control" name="new">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Описание</label>
							<div class="col-md-1">
								<textarea name="description"cols="70" rows="10" wrap="soft | hard"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Загрузка файла</label>
							<div class="col-md-1">
								<input type="file"  name="image">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
							Создать объявление
								</button>
							</div>
						</div>
					</form>

				
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
