<form action='{{route('reg')}}' method='post'>
@csrf
<select name='cert'>
	@foreach($certificates as $certificate)
	<option value='{{$certificate->Subject->Name}}'>{{$certificate->Subject->Name}}</option>
	@endforeach
</select>
<input type='text' name='password'>
<button type='submit'>Register</button>
</form>

