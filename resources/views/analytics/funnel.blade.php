@extends('layout')
@section('title', 'Sotuv voronkasi tahlili')
@section('header-text', "Sotuv voronkasi tahlili")
@section('content')
    <div class="container tbl mb-5" >
        <!-- filter by date -->
        <div class="filter-by-date">
            <form action="/analytics/funnel" class="filter-select">
                <p style="font-size:17px; margin-bottom:4px">Saralash:</p>
                <select name="order" class="form-select" id="order" onchange="this.form.submit()">
                    <option value="today">Bugun</option>
                    <option value="thisWeek" selected>Shu hafta</option>
                    <option value="lastWeek">O'tkan hafta</option>
                    <option value="thisMonth">Shu oy</option>
                    <option value="lastMonth">O'tkan oy</option>
                    <option value="thisYear">Shu yil</option>
                    <option value="lastYear">O'tkan yil</option>
                    <option value="all">Hammasi</option>
                    @isset($filterFrom)
                        <option value="-" selected>-</option>
                    @endisset
                </select>
            </form>
            <form action="/analytics/funnel" class="date-filter">
                <p style="font-size:17px; margin-bottom: 4px;">Vaqt oralig'i boyicha saralash:</p>
                @error('filterFrom')
                    <div class="alert alert-danger py-1 mb-1">{{ $message }}</div>
                @enderror
                @error('filterTo')
                    <div class="alert alert-danger py-1 mb-1">{{ $message }}</div>
                @enderror
                <div class="input-group">
                    <input type="date" name="filterFrom" id="filterFrom" class="form-control form-control @error('filterFrom') is-invalid @enderror" value="{{ isset($filterFrom) ? $filterFrom : old('filterFrom') }}">
                    <span class="input-group-text">⇆</span>
                    <input type="date" name="filterTo" id="filterTo" class="form-control @error('filterTo') is-invalid @enderror" value="{{ isset($filterTo) ? $filterTo : old('filterTo') }}">
                    <button type="submit" class="btn btn-secondary" >Saralash</button>    
                </div>
            </form>
        </div>
        <!-- end of filter by date -->

        <!-- All results wrapper -->
        <h5 class="{{ $allD[0]? 'd-none' : '' }}">- Natijalar topilmadi!</h5>
        <div class="results-wrapper w-100 {{ $allD[0]? '' : 'd-none' }}">
            <!-- table -->
            <div class="row">
                <table class="table bg-white" style="width:100%;" id="c-table" data-page-length="10">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Qadam</th>
                            <th>O'tilgan</th>
                            <th>O'tilmagan</th>
                            <th>O'tilmagan Summa</th>
                        </tr>          
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Birinchi suhbat</td>
                            <td class="seperator-quantity">{{ $allD[0] }}</td>
                            <td class="seperator-quantity">{{ $allS[0] }}</td>
                            <td class="seperator">{{ $allM[0] }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Ko'ndirish jarayoni</td>
                            <td class="seperator-quantity">{{ $allD[1] }}</td>
                            <td class="seperator-quantity">{{ $allS[1] }}</td>
                            <td class="seperator">{{ $allM[1] }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bitm tuzildi</td>
                            <td class="seperator-quantity">{{ $allD[2] }}</td>
                            <td class="seperator-quantity">{{ $allS[2] }}</td>
                            <td class="seperator">{{ $allM[2] }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>To'lov qilindi</td>
                            <td class="seperator-quantity">{{ $allD[3] }}</td>
                            <td class="seperator-quantity">{{ $allS[3] }}</td>
                            <td class="seperator">{{ $allM[3] }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Yakunlandi</td>
                            <td class="seperator-quantity">{{ $allD[4] }}</td>
                            <td class="seperator-quantity">{{ $allS[4] }}</td>
                            <td class="seperator">{{ $allM[4] }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Qaytarib berildi</td>
                            <td class="seperator-quantity">{{ $allD[5] }}</td>
                            <td class="seperator-quantity">{{ $allS[5] }}</td>
                            <td class="seperator">{{ $allM[5] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end of table -->

        

            <!-- mijozlar soni boyicha -->
            <div class="row justify-content-between">
                <h5 class="text-center mb-3">Grafiklar</h5>
                <div style="width:48%" class="bg-white rounded p-2">
                    <canvas id="barChart" width="400" height="400"></canvas>
                </div>
                <div style="width:48%" class="bg-white rounded p-2">
                    <canvas id="pieChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>

    </div>

@section('script')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.js"></script>
    <script>
        // saralash
        @isset($date)
            $('#order option[value="{{ $date }}"]').attr("selected","selected")
        @endisset

        // table
        $('#c-table').DataTable({
            dom: '<"make-excel" B> <"show-filter-wrapper" lf> r <"table-wrapper"t> ip',
            language: {
                "lengthMenu": " _MENU_ tadan",
                "zeroRecords": "Hechnarsa topilmadi",
                "info": "_PAGES_ - _PAGE_",
                "infoEmpty": "No records available",
                "infoFiltered": "(Umumiy _MAX_ qayddan filtrlandi)",
                "search":"Qidirish:",
                "Next":"dsa",
                "paginate": {
                    "previous": "<",
                    "next":">"
                }
            },
            scrollX: true,
            paging: true,
            "lengthMenu": [10,20,40,60,100,200],
            "order":[],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        //number seperator to money format
        function numberWithSpaces(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }
        for (let i=0; i < $('.seperator').length; i++ ) {     
            $(".seperator")[i].innerText=numberWithSpaces($(".seperator")[i].innerText)+' UZS' ;
        }
        for (let i=0; i < $('.seperator-quantity').length; i++ ) {     
            $(".seperator-quantity")[i].innerText=numberWithSpaces($(".seperator-quantity")[i].innerText)+' x' ;
        }

        // barChart mijozlar soni bo'yicha
        const barChart = document.getElementById('barChart').getContext('2d');
        const barChart1 = new Chart(barChart, {
            type: 'bar',
            data: {
                labels: ['Birinchi suhbat: 100%', "Ko'ndirish jarayoni: " + parseInt(100/{{ $allD[0] }} * {{ $allD[1] }}) + '%' , "Bitm tuzildi: " + parseInt(100/{{ $allD[0] }}* {{ $allD[2] }}) + '%', "To'lov qilindi: " + parseInt(100/{{ $allD[0] }}* {{ $allD[3] }}) + '%', "Yakunlandi: " + parseInt(100/{{ $allD[0] }}* {{ $allD[4] }}) + '%', "Qaytarib berildi: " + parseInt(100/{{ $allD[0] }}* {{ $allD[5] }}) + '%'],
                datasets: [{
                    label: 'scale ',
                    data: [@foreach($allD as $a) {{ $a }}, @endforeach],
                    backgroundColor: [
                        '#34568B',
                        '#EFC050',
                        '#45B8AC',
                        '#009B77',
                        '#5B5EA6',
                        '#9B2335'
                    ],
                }]
            },
            options: {
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },  
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sotuv voronksi',
                    }
                }
            }
        });

        // pieChart mijozlar soni bo'yicha
        const ctx = document.getElementById('pieChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Google: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Google'] }}).toFixed(1) + '%' , "Yandex: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Yandex'] }}).toFixed(1) + '%' , "Telegram: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Telegram'] }}).toFixed(1) + '%', "Instagram: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Instagram'] }}).toFixed(1) + '%', "Reklama: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Reklama'] }}).toFixed(1) + '%', "Tanish-blish: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Tanish-blish'] }}).toFixed(1) + '%', "Qayta-xarid: "+ parseFloat(100 / {{ $allD[0] }} * {{ $awareness['Qayta-xarid'] }}).toFixed(1) + '%'],
                datasets: [{
                    label: 'Sotuv voronkasi',
                    data: [{{ $awareness['Google'] }}, {{ $awareness['Yandex'] }}, {{ $awareness['Telegram'] }}, {{ $awareness['Instagram'] }}, {{ $awareness['Reklama'] }}, {{ $awareness['Tanish-blish'] }}, {{ $awareness['Qayta-xarid'] }}],
                    backgroundColor: [
                        '#63ace5',
                        '#ff0000',
                        '#229ED9',
                        '#C13584',
                        '#35a79c',
                        '#051e3e',
                        '#7bc043'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Xabardorlik',
                    }
                }
            },
        });

   
    </script> 
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/fh-3.2.1/r-2.2.9/datatables.min.css"/>
    <style>
        .chart{
            width: 400px;
            height: 400px;
            background-color: white;
        border-radius: 5px;
        }
        .filter-select{
            width:180px;
            margin-right:10px;
            margin-bottom: 6px;
        }
        .date-filter{
            width:500px;
        }
        .filter-by-date{
            display:flex;
            flex-wrap: wrap;
            margin-top:10px;
            margin-bottom: 30px;
        }    

        @media (max-width:447px){
            .date-filter{
                width:100%;
            }   
        }
    </style>
@endsection 
@endsection