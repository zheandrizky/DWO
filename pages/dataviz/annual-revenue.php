<?php

$query = "
    SELECT 
        d.year,
        SUM(fs.total_revenue) AS total_revenue
    FROM fact_sales fs
    JOIN date d ON fs.id_date = d.id_date
    GROUP BY d.year
    ORDER BY d.year ASC
    LIMIT 5
";

$result = $conn->query($query);

$years = [];
$revenues = [];

while ($row = $result->fetch_assoc()) {
  $years[] = $row['year'];
  $revenues[] = (float)$row['total_revenue'];
}
?>


<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h4 class="fw-semibold mb-2">Total Revenue per Tahun</h4>
      <p class="text-muted mb-4">Menampilkan total penjualan (revenue) selama 5 tahun terakhir.</p>

      <div id="chartAnnualRevenue"></div>
    </div>
  </div>
</div>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    const years = [2021, 2022, 2023, 2024, 2025];
    const revenue = [120000000, 150000000, 175000000, 160000000, 210000000];

    var options = {
      chart: {
        type: 'line',
        height: 320,
        toolbar: {
          show: false
        }
      },
      series: [{
        name: 'Revenue',
        data: revenue
      }],
      xaxis: {
        categories: years,
        title: {
          text: 'Tahun'
        }
      },
      yaxis: {
        title: {
          text: 'Total Revenue (Rp)'
        },
        labels: {
          formatter: (val) => 'Rp ' + Math.round(val).toLocaleString('id-ID')
        }
      },
      stroke: {
        width: 3
      },
      markers: {
        size: 5
      },
      tooltip: {
        y: {
          formatter: (val) => 'Rp ' + Math.round(val).toLocaleString('id-ID')
        }
      },
      grid: {
        show: true,
        strokeDashArray: 4
      },
      colors: ['#5D87FF']
    };

    new ApexCharts(document.querySelector("#chartAnnualRevenue"), options).render();
  });
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const years = <?= json_encode($years) ?>;
    const revenue = <?= json_encode($revenues) ?>;

    var options = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: { show: false }
        },
        series: [{
            name: 'Revenue',
            data: revenue
        }],
        xaxis: {
            categories: years,
            title: { text: 'Tahun' }
        },
        yaxis: {
            title: { text: 'Total Revenue (Rp)' },
            labels: {
                formatter: function (val) {
                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                }
            }
        },
        stroke: { width: 3 },
        markers: { size: 5 },
        tooltip: {
            y: {
                formatter: function (val) {
                    return 'Rp ' + Number(val).toLocaleString('id-ID');
                }
            }
        },
        grid: {
            strokeDashArray: 4
        },
        colors: ['#5D87FF']
    };

    new ApexCharts(
        document.querySelector("#chartAnnualRevenue"),
        options
    ).render();
});
</script>
