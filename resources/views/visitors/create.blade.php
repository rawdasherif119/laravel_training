@extends('layouts.admin')

@section('content')


<form id="form" action="{{route('visitors.store')}}" method ="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group" style="width:500px">
      <label for="first_name">First Name:</label>
      <input type="text" class="form-control" id="first_name" name="first_name">
    </div>

    <div class="form-group" style="width:500px">
      <label for="last_name">Last Name:</label>
      <input type="text" class="form-control" id="last_name" name="last_name">
    </div>

    <div class="form-group">
    <label for="disabledTextInput"> Gender:</label>
    <select  id="exampleFormControlSelect1" name="gender">
    <option value="male" >Male</option>
    <option value="female">Female</option>
    </select>
    </div>

    <div class="form-group" style="width:500px">
      <label for="email">Email:</label>
      <input type="text" class="form-control" id="email" name="email">
    </div>

    <div class="form-group" style="width:500px">
      <label for="phone">Phone:</label>
      <input id="phone" type="phone" class="form-control" name="phone" >
    </div>


    <div class="form-group" style="width:500px">
      <label for="country_id">Country :</label>
      <select id="country_id" class="form-control" name="country_id">
        <option selected>Choose...</option>
        @foreach ($countries as $key =>$country)
      <option value="{{$key}}">{{$country}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="city_id">Select City:</label>
      <select name="city_id" id="city_id" class="form-control" style="width:350px">
      </select>
    </div>

    <br>
    <div class="form-group" style="width:500px">
    <label for="image">Image:</label>
    <input type="file" name="image" >
    </div>


  <button type="submit" class="btn btn-primary">Add Vistor</button>


</form>

@push('scripts')
<script type="text/javascript">
 $('#country_id').change(function(){
    var countryID = $(this).val();   
    if(countryID){
      $.ajax({
        type:"GET",
           url:"{{url('get-cities')}}?country_id="+countryID,
           success:function(data){  
            if(data){
                $("#city_id").empty();
                $("#city_id").append('<option>Select</option>');
                $.each(data,function(key,value){
                    $("#city_id").append(`<option value='${key}' >${value}</option>`);
                });
           }else{ 
             $("#city_id").empty(); 
           }             
          } 
      }); 
    }else{
     $("#city_id").empty(); 
    }       
  });
</script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\VisitorRequest') !!}
@endpush
@endsection