@extends('layout')
@section('title', "Mijoz tahrirlash")
@section('header-text', "Mijoz tahrirlash")

@section('content')

<div class="container container-bg">

<form method="post" action="{{ route('client-base.update', $client) }}">
    @method('PUT')
    @csrf
    @include('clients.form')
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-success px-3 py-2 mt-3">Tahrirlash</button>
    </div>
</form> 
</div>
    



@endsection

@section('script')
<script>

$(document).ready(function(){
    // dateOfBirth min and max value
    let minyear = new Date().getFullYear()-80;
    let maxyear = new Date().getFullYear()-12;
    let month = new Date().getMonth()+1;
    let date = new Date().getDate();
    $("#dateOfBirth").attr('min',minyear+'-'+ month + '-' + date );
    $("#dateOfBirth").attr('max',maxyear+'-'+ month + '-' + date );
    // end of dateOfBirth min and max value

    // show errors to input fields
    let type = "{{ $errors->first('type') }}";
    let company_code = "{{ $errors->first('company_code') }}";
    let master_code = "{{ $errors->first('master_code') }}";
    let name = "{{ $errors->first('name') }}";
    let surname = "{{ $errors->first('surname') }}";
    let dateOfBirth = "{{ $errors->first('dateOfBirth') }}";
    let phone1 = "{{ $errors->first('phone1') }}";
    let phone2 = "{{ $errors->first('phone2') }}";
    let region = "{{ $errors->first('region') }}";
    let address = "{{ $errors->first('address') }}";
    let feedback = "{{ $errors->first('feedback') }}";
    fields=[type,company_code,master_code,name,surname,dateOfBirth,phone1,phone2,region,address,feedback]
    fields2=['type','company_code','master_code','name','surname','dateOfBirth','phone1','phone2','region','address','feedback']
 for(let i=0;i<fields.length;i++){
    if(fields[i]!==''){
        if(fields2[i]=='company_code'){
            $('#company_code').parent().next().append(fields[i])
            $('#'+fields2[i]+'').addClass('is-invalid')
            $('#'+fields2[i]+'').parent().next().show()
        }
        else if(fields2[i]=='master_code'){
            $('#master_code').parent().next().append(fields[i])
            $('#'+fields2[i]+'').addClass('is-invalid')
            $('#'+fields2[i]+'').parent().next().show()
        }
        else{
            $('#'+fields2[i]+'').addClass('is-invalid')
            $('#'+fields2[i]+'').next().append(fields[i])
            $('#'+fields2[i]+'').next().show()
        }
    }
 }
// end of show errors to input fields

    // choose client
    if(jQuery('#type').val()=="Kompaniya xodimi"){
    jQuery('#company-wrapper').removeClass("disabled-div")
    jQuery('#master-wrapper').addClass("disabled-div")
}else if (jQuery("#type").val()=="Usta"){
     jQuery('#master-wrapper').removeClass("disabled-div")
     jQuery('#company-wrapper').addClass("disabled-div")
}
else{
    jQuery('#company-wrapper').addClass("disabled-div")
    jQuery('#master-wrapper').addClass("disabled-div")
}
    jQuery('#type').change(function(){
if(jQuery('#type').val()=="Kompaniya xodimi"){
    jQuery('#company-wrapper').removeClass("disabled-div")
    jQuery('#master-wrapper').addClass("disabled-div")
}
else if (jQuery("#type").val()=="Usta"){
     jQuery('#master-wrapper').removeClass("disabled-div")
     jQuery('#company-wrapper').addClass("disabled-div")
}
else{
    jQuery('#company-wrapper').addClass("disabled-div")
    jQuery('#master-wrapper').addClass("disabled-div")
}
});
// end of choose client


//send data with enter button
$("#addcompanyname").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#addcompany").click();
    }
});
$("#master-type").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#add-master-type-to-base").click();
    }
});
//end of send data with enter button

//add company to base
    $(document).on('click', '#addcompany', function(e){
    e.preventDefault();
    let company= {
        'company': $("#addcompanyname").val(),
    }
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $.ajax({
            type:'POST',
            url:'/companies-base',
            data: company,
            success: function(response){
                if(response.status == 400){

                    $.each(response.errors, function(key,err_values){
                    $('#company-added-error').hide()
                    $('#company-added-error').empty()
                    $('#company-added-error').append(err_values)
                    $('#company-added-error').show(100)
                    $('#company-added-successfully').hide()
                    });
                }
            else {
                $('#company-added-successfully').hide()
                $('#company-added-successfully').empty()
                $('#company-added-successfully').append('"'+response['company']+'"'+' nomli kompaniya bazaga muvaffaqiyatli kiritildi!')   
                $('#company-added-error').hide()
                $('#company-added-successfully').show(100)
                let id=response['id'];
                let name=response['company'];
                $('#company_code').append('<option selected value="'+id+'">'+name+'</option>')
            }
            }
        })
    });
// end of add company to base

//add master_type to base
$(document).on('click', '#add-master-type-to-base', function(e){
    e.preventDefault();
   
    let masters= {
        'master': $("#master-type").val(),
    }
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $.ajax({
            type:'POST',
            url:'/masters-base',
            data: masters,
            success: function(response){
                if(response.status == 400){

                    $.each(response.errors, function(key,err_values){
                    $('#master-type-added-error').hide()
                    $('#master-type-added-error').empty()
                    $('#master-type-added-error').append(err_values)
                    $('#master-type-added-error').show(100)
                    $('#master-type-added-successfully').hide()
                    });
                }
            else {
                $('#master-type-added-successfully').hide()
                $('#master-type-added-successfully').empty()
                $('#master-type-added-successfully').append(response['master']+' nomli usta turi bazaga muvaffaqiyatli kiritildi!')   
                $('#master-type-added-error').hide()
                $('#master-type-added-successfully').show(100)
                let id=response['id'];
                let name=response['master'];
                $('#master_code').append('<option selected value="'+id+'">'+name+'</option>')
            }
            }
        })
    });
// end of add master_type to base

});
</script>

@endsection