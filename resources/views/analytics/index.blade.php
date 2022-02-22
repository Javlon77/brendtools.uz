@extends('layout')
@section('title', 'Tahlil')
@section('header-text', "Tahlil")
@section('content')
<div class="container tbl" >
<div class="chart">
<canvas id="myChart" width="400" height="400"></canvas>
</div>
</div>




@section('script')
<script src="{{ asset('js/chart.min.js') }}"></script>
<script>
    
</script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
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
                beginAtZero: true
            }
        }
        
    }
});
</script>
   
@endsection
@section('css')
<style>
    .chart{
        width: 400px;
        height: 400px;
        background-color: white;
    border-radius: 5px;
    }
</style>
@endsection 





@endsection