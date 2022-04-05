<script>
    jQuery(document).ready(function(){
        //separator number
        function numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        for (let i=0; i < $('.seperator').length; i++ ) {     
            $(".seperator")[i].value=numberWithSpaces($(".seperator")[i].value)
        }
        $("#price").on('input' ,function(){
            if(this.value!==''){
                let a = $("#price").val().replace(/\s/g, '')
                let p = parseInt(a)
                if(isNaN(p)){
                    $("#price").val('')
                }
                else{
                    $("#price").val(numberWithSpaces(p))
                }
            }
        });       

        //choose client
        $('#c-table').on('click','.choose-client', function() {
            let id = jQuery(this).attr('idx');
            let name= jQuery(this)[0].children[1].textContent;
            jQuery('#client_id').append('<option value="'+id+'" selected>'+name+'</option>');
            $('#choose-client-modal').modal('hide');
        });
        //search client
        jQuery(document).on('keyup', '#search-client', function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let text =jQuery('#search-client').val();
            let token = $('meta[name=token]').attr('content');

            if(jQuery.trim(text)!==''){
                if(jQuery.trim(text).length>2){
                    jQuery.ajax({
                        method: 'POST',
                        url: '/api/client',
                        headers:{
                            'Authorization':token 
                        },
                        dataType: 'json',
                        data: {
                            'search': text
                        },
                        success : function(response){
                            if(response[1].length!==0){
                                let raw = '';
                                jQuery('.add-client').html('');
                                jQuery.each(response[1], function(index ,value){ 
                                    index=index+1;
                                    if(value.company_code==null){value.company_code='-'}else{  value.company_code = response[0].find(x => x.id === value.company_code).company };
                                    if(value.master_code==null){value.master_code='-'}else{  value.master_code = response[2].find(x => x.id === value.master_code).master };
                                    if(value.phone2==null){value.phone2='-'}
                                    if(value.address==null){value.address='-'}
                                    if(value.feedback==null){value.feedback='-'}
                                    if(value.surname == null) {value.surname = '-'}
                                    raw = ' <tr class="choose-client" idx="'+value.id +'"><td>'+ index +'</td><td>'+ value.name+'</td><td>'+ value.surname+'</td><td>'+ value.type+'</td><td>'+ value.company_code+'</td><td>'+ value.master_code+'</td><td>'+ value.phone1+'</td><td>'+ value.phone2+'</td><td>'+ value.region+'</td><td>'+ value.address+'</td><td>'+ value.feedback+'</td> </tr>  '
                                    jQuery('.add-client').append(raw);
                                });                  
                            }
                            else{
                                jQuery('.add-client').html('<tr class="text-uppercase" style="font-weight: bold;"><td>t</td><td>o</td><td>p</td><td>i</td><td>l</td><td>m</td><td>a</td><td>d</td><td>i</td></tr>');
                            }
                        }
                    })         
                }
                else{
                    jQuery('.add-client').html('<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>');
                }
            }
            else{
                jQuery('.add-client').html('<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>');
            }
        }); 
        // END OF SEARCH CLIENT            
    });
</script>