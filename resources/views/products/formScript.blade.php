<script>
$(document).ready(function() {
    // token for headers all
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //add brand to base
    $(document).on('click', '#add-brand', function(e) {
        e.preventDefault();
        let brand = {
            'brand': $("#brand_input").val(),
        }
        $.ajax({
            method: 'POST',
            url: '/brands',
            data: brand,
            success: function(response) {
                if (response.status == 400) {
                    $.each(response.errors, function(key, err_values) {
                        $('#brand-error').hide()
                        $('#brand-error').empty()
                        $('#brand-error').append(err_values)
                        $('#brand-error').show(100)
                        $('#brand-success').hide()
                    });
                } else {
                    $('#brand-success').hide()
                    $('#brand-success').empty()
                    $('#brand-success').append(response['brand'] +
                        ' nomli brend bazaga muvaffaqiyatli kiritildi!')
                    $('#brand-error').hide()
                    $('#brand-success').show(100)
                    let id = response['id'];
                    let name = response['brand'];
                    $('#brand_id').append('<option selected value="' + id + '">' + name +
                        '</option>')
                }
            }
        });
    });
    // end of add brand to base

    //add category to base
    $(document).on('click', '#add-category', function(e) {
        e.preventDefault();

        let category = {
            'category': $("#category_input").val(),
        }
        $.ajax({
            method: 'POST',
            url: '/categories',
            data: category,
            success: function(response) {
                if (response.status == 400) {
                    $.each(response.errors, function(key, err_values) {
                        $('#category-error').hide()
                        $('#category-error').empty()
                        $('#category-error').append(err_values)
                        $('#category-error').show(100)
                        $('#category-success').hide()
                    });
                } else {
                    $('#category-success').hide()
                    $('#category-success').empty()
                    $('#category-success').append(response['category'] +
                        ' nomli kategorya turi bazaga muvaffaqiyatli kiritildi!')
                    $('#category-error').hide()
                    $('#category-success').show(100)
                    let id = response['id'];
                    let name = response['category'];
                    $('#category_id').append('<option selected value="' + id + '">' + name +
                        '</option>')
                }
            }
        });
    });
    // end of add category to base

    // send modal forms with enter button
    $("#category_input").keypress(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $("#add-category").click();
        }
    });
    $("#brand_input").keypress(function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $("#add-brand").click();
            return false;
        }
    });
    // end of send modal forms with enter button

    //enable disable link form 
        if( $('#hasInSite').val() == 0 ){
            $('.link').addClass('disabled-div') 
            $('#link').prop('required',false)
        }
        else{
            $('.link').removeClass('disabled-div')
            $('#link').prop('required',true)
        }
    $('#hasInSite').on('change', function(){
        if( $('#hasInSite').val() == 0 ){
            $('.link').addClass('disabled-div')
            $('#link').val('');
            $('#link').prop('required',false)
        }
        else{
            $('.link').removeClass('disabled-div')
            $('#link').val('');
            $('#link').prop('required',true)
        }
    });
});
</script>