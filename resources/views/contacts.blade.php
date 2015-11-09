@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Наши контакты</div>
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


				<div class="panel-body">
					Адрес
					Телефон
					<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=SmZuk37JUydSt1CPZxE_a332FrLfUWdU&width=900&height=400&lang=ru_RU&sourceType=constructor"></script>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection