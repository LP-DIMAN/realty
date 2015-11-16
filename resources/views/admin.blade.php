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


				<div class="panel-body">
					
					
				</div>
			</div>
		</div>
	</div>
</div>



@endsection