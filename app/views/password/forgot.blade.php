@if($errors->has('email'))
  {{ $errors->first('email') }}
@endif

{{ Form::open(array('route' => 'password-remind-post')) }}
 
  <p>{{ Form::label('email', 'Email') }}
  {{ Form::text('email') }}</p>
 
  <p>{{ Form::submit('Submit') }}</p>
 
{{ Form::close() }}
