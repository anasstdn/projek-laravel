@extends('layouts.app')

@section('content')
<div class="bg-image" style="background-image: url('{{asset('codebase/')}}/src/assets/media/photos/photo8@2x.jpg');">
  <div class="content content-top">
    <div class="row push">
      <div class="col-md py-10 d-md-flex align-items-md-center text-center">
        <h1 class="text-white mb-0">
          <span class="font-w300">Grafik Penjualan</span>
        </h1>
      </div>
    </div>
  </div>
</div>

<!-- Page Content -->
<div class="bg-white">
	<!-- Breadcrumb -->
	<div class="content">
		<nav class="breadcrumb mb-0">
			<a class="breadcrumb-item" href="javascript:void(0)">Transaksi</a>
			<span class="breadcrumb-item active">Grafik Penjualan</span>
		</nav>
	</div>
	<!-- END Breadcrumb -->

	<!-- Content -->
	<div class="content">
		<div class="block">
			<div class="block-content block-content-full">
				<div class="row">
					<div class="col-lg-12 col-xl-12">
						<div class="card">
							<div class="card-header text-uppercase">GRAFIK TRANSAKSI PRODUK TAHUNAN</div>
							<div class="card-body">
                               <div id="grafik"></div>
							</div>
						</div>
					</div>
				</div><!--End Row-->
                <hr/>
                 <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header text-uppercase">GRAFIK PIE TRANSAKSI PRODUK</div>
                            <div class="card-body">
                               <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header text-uppercase">GRAFIK TOTAL PENJUALAN PRODUK TAHUNAN (SATUAN METER KUBIK)</div>
                            <div class="card-body">
                               <div id="grafik_penjualan"></div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
$(document).ready(function(){

    $.ajax({
      url: '{{url('penjualan/get-chart')}}',
      type: 'GET',
      // data: {tahun:$('#tahun').val()},
      // xhr: function () {
      //   var xhr = new window.XMLHttpRequest();
      //   xhr.upload.addEventListener("progress",
      //     uploadProgressHandler,
      //     false
      //     );
      //   xhr.addEventListener("load", loadHandler, false);
      //   xhr.addEventListener("error", errorHandler, false);
      //   xhr.addEventListener("abort", abortHandler, false);

      //   return xhr;
      // },
      success:function(data){
        chart_penjualan(data.bulan,data.total_transaksi);
        chart_total(data.bulan,data.total_pasir,data.total_abu,data.total_gendol,data.total_split_1,data.total_split_2,data.total_lpa)
        chart_pie(data.label_pie,data.graph_pie);
      },
      error:function (xhr, status, error){
        alert(xhr.responseText);
    },
});
})


function chart_penjualan(label,total)
{
    var options = {
            chart: {
                height: 350,
                type: 'area',
                stacked: false,
                zoom: {
                      enabled: false
                    },
                foreColor: '#4e4e4e',
                toolbar: {
                      show: false
                    },
                shadow: {
                    enabled: false,
                    color: '#000',
                    top: 3,
                    left: 2,
                    blur: 3,
                    opacity: 1
                },
            },
            stroke: {
                width: 4,   
                curve: 'straight',
            },
            series: [
            {
                name: 'Total Transaksi',
                data: total,
            },
            // {
            //     name: 'Dislike',
            //     data: [10, 10, 10, 9, 10, 10, 22, 9, 12, 7, 10, 5, 13, 9, 10, 2, 7, 10],
            // },
            ],

            tooltip: {
                enabled: true,
                theme: 'dark',
            },
            markers:{
                size:3
            },

            xaxis: {
                labels: {
                    format: 'dd/MM',
                },
                categories: label,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    // shade: 'dark',
                    // gradientToColors: [ '#00dbde'],
                    // shadeIntensity: 1,
                    // type: 'horizontal',
                    // opacityFrom: 1,
                    // opacityTo: 1,
                    // stops: [0, 100, 100, 100]
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                },
            },
            colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800'],
            grid:{
                show: true,
                borderColor: 'rgba(66, 59, 116, 0.15)',
            },
            yaxis: {
                // min: -10,
                // max: 40,                
            }
        }

       var chart = new ApexCharts(
            document.querySelector("#grafik"),
            options
        );
        
        chart.render();
}

function chart_total(label,pasir,abu,gendol,split1,split2,lpa)
{
    var options = {
            chart: {
                height: 500,
                type: 'area',
                stacked: false,
                zoom: {
                      enabled: false
                    },
                foreColor: '#4e4e4e',
                toolbar: {
                      show: false
                    },
                shadow: {
                    enabled: false,
                    color: '#000',
                    top: 3,
                    left: 2,
                    blur: 3,
                    opacity: 1
                },
            },
            stroke: {
                width: 4,   
                curve: 'smooth',
            },
            series: [
            {
                name: 'Pasir',
                data: pasir,
            },
            {
                name: 'Abu',
                data: abu,
            },
            {
                name: 'Gendol',
                data: gendol,
            },
            {
                name: 'Split 1/2',
                data: split1,
            },
            {
                name: 'Split 2/3',
                data: split2,
            },
            {
                name: 'LPA',
                data: lpa,
            },
            ],

            tooltip: {
                enabled: true,
                theme: 'dark',
            },
            markers:{
                size:3
            },

            xaxis: {
                labels: {
                    format: 'dd/MM',
                },
                categories: label,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    // shade: 'dark',
                    // gradientToColors: [ '#00dbde'],
                    // shadeIntensity: 1,
                    // type: 'horizontal',
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                },
            },
            colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800'],
            grid:{
                show: true,
                borderColor: 'rgba(66, 59, 116, 0.15)',
            },
            yaxis: {
                // min: -10,
                max: 3000,                
            }
        }

       var chart = new ApexCharts(
            document.querySelector("#grafik_penjualan"),
            options
        );
        
        chart.render();
}

function chart_pie(label,data)
{
    // console.log(data);
    var options = {
      series: data,
      chart: {
          width: '50%',
          type: 'pie',
      },
      labels: label,
      theme: {
          monochrome: {
            enabled: false
        }
    },
    plotOptions: {
      pie: {
        dataLabels: {
          offset: -5
      }
  }
},

dataLabels: {
  formatter(val, opts) {
    const name = opts.w.globals.labels[opts.seriesIndex]
    return [name, val.toFixed(1) + '%']
}
},
legend: {
  show: true
}
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

}
</script>
@endpush