{{-- created_at & updated_at --}}
<div class="mb-3" style="width:170px">
    <label for="" class="form-label j-label" >Vaqt  </label>
    <input type="date" class="form-control" name="created_at" value="@if(isset($funnel)){{ $funnel->created_at->format('Y-m-d') }}@else{{ now()->format('Y-m-d') }}@endif" min="2022-01-01" max="2035-01-01" required>
</div>

<div class="j-row ">
    <!--mijoz -->
    <div class="mb-3 input-width">
        <label for="client_id" class="form-label j-label">Mijoz<strong class="text-danger">*</strong></label>
        <div class="input-group">
            <select class="form-control" id="client_id" name="client_id" value="" style="pointer-events: none;" required>
                <option selected value="@if(isset($funnel)){{ $funnel->client_id }}@endif">@if(isset($funnel)){{ $clients->keyBy('id')[$funnel->client_id]->name }}@endif</option>
            </select>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#choose-client-modal"><strong>+</strong> qo'shish</button>
        </div>
    </div>    
    <!--status -->
    <div class="mb-3 input-width">
        <label for="status" class="form-label j-label"> Status <strong class="text-danger">*</strong></label>
        <select id="status"  name="status" class="form-select">
            <option selected value="Birinchi suhbat">Birinchi suhbat</option>
            <option value="Ko'ndirish jarayoni">Ko'ndirish jarayoni</option>
            <option value="Bitm tuzildi">Bitm tuzildi</option>
            <option value="To'lov qilindi">To'lov qilindi</option>
            <option value="Yakunlandi">Yakunlandi</option>
            <option value="Qaytarib berildi">Qaytarib berildi</option>
            @if( isset($funnel) )
                <option value="{{ $funnel->status }}" selected>{{ $funnel->status }}</option>
            @endif
        </select>
    </div>    
    <!-- qayerdan eshitdi -->
    <div class="mb-3 input-width">
        <label for="awareness" class="form-label j-label">Xabardorlik <strong class="text-danger">*</strong></label>
        <select id="awareness"  name="awareness" class="form-select">
            <option selected value="Google">Google</option>
            <option value="Yandex">Yandex</option>
            <option value="Telegram">Telegram</option>
            <option value="Instagram">Instagram</option>
            <option value="Facebook">Facebook</option>
            <option value="Reklama">Reklama</option>
            <option value="Tanish-blish">Tanish-blish</option>
            <option value="Qayta-xarid">Qayta-xarid</option>
            @if( isset($funnel) )
                <option value="{{ $funnel->awareness }}" selected>{{ $funnel->awareness }}</option>
            @endif
        </select>
    </div>  
    <!-- kerak bo'lgan mahsulot narxi -->
    <div class="mb-3 input-width">
        <label for="price" class="form-label j-label">Umumiy qiymat <strong class="text-success">*</strong></label>
        <div class="input-group mb-3">
            <input type="text" class="form-control seperator" id="price" name="price" style="text-align:right" value="@if( isset($funnel) ) {{ $funnel->price }} @endif">
            <span class="input-group-text" id="basic-addon2">So'm</span>
        </div>
    </div>   
    <!-- kerak bo'lgan mahsulot -->
    <div class="mb-3 input-width">
        <label for="product" class="form-label j-label">Mahsulotlar</label>
        <textarea name="product" id="product" cols="30" rows="1" class="form-control" maxlength="1999">@if( isset($funnel) ){{ $funnel->product }}@endif</textarea>
    </div>     
    <!-- Qo'shimcha -->
    <div class="mb-3 input-width">
        <label for="additional" class="form-label j-label"> Qo'shimchalar</label>
        <textarea name="additional" id="additional" cols="30" rows="1" class="form-control" maxlength="999">@if( isset($funnel) ){{ $funnel->additional }}@endif</textarea>
    </div>     
</div>

<!-- Modal -->
<div class="modal fade" id="choose-client-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl text-dark">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="exampleModalLabel">Mijozni qidirish:</h5>
                <input type="text" class="form-control input-width mb-0" id="search-client" placeholder="Ism, familiya, telefon">
            
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
            <div class="table-responsive rounded">
                <table class="table" style="width:100%" id="c-table" data-page-length='25'>
                    <thead>
                        <tr>
                            <th>T/R</th>
                            <th>Ism</th>
                            <th>Familiya</th>
                            <th>Kim</th>
                            <th>Kompaniya</th>
                            <th>Usta</th>
                            <th>Telefon</th>
                            <th>Telefon 2</th>
                            <th>Viloyat</th>
                            <th>Manzil</th>
                            <th>fikr</th>
                        </tr>        
                    </thead>
                    <tbody class="add-client">
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
            </div>
        </div>
    </div>
</div>
<!--  end of modal  -->