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
					

				<form class="form-horizontal" role="form" method="POST" action="adverts">
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
								<input type="text" class="form-control" name="city" value="{{ old('city') }}">
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
								<input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="в рублях">
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
								<textarea name="description"cols="70" rows="10"></textarea>
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
