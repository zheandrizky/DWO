<?php
$query = "
    SELECT 
        r.region_name,
        SUM(fs.total_revenue) AS total_revenue
    FROM fact_sales fs
    JOIN region r ON fs.id_region = r.id_region
    GROUP BY r.region_name
    ORDER BY total_revenue DESC
";

$result = $conn->query($query);

$branches = [];
$branchSales = [];

while ($row = $result->fetch_assoc()) {
    $branches[] = $row['region_name'];
    $branchSales[] = (float)$row['total_revenue'];
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="fw-semibold mb-2">Sales per Branch/Territory</h4>
            <p class="text-muted mb-4">Total penjualan dari semua cabang pada periode yang sama.</p>

            <div id="chartBranchSales"></div>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        const branches = ['Surabaya', 'Sidoarjo', 'Malang', 'Gresik', 'Jombang'];
        const branchSales = [520, 410, 390, 210, 160]; // misal juta

        var options = {
            chart: {
                type: 'donut',
                height: 340
            },
            series: branchSales,
            labels: branches,
            tooltip: {
                y: {
                    formatter: (val) => val + ' Juta'
                }
            },
            legend: {
                position: 'bottom'
            }
        };

        new ApexCharts(document.querySelector("#chartBranchSales"), options).render();
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const branches = <?= json_encode($branches); ?>;
        const branchSales = <?= json_encode($branchSales); ?>;

        var options = {
            chart: {
                type: 'donut',
                height: 340
            },
            series: branchSales,
            labels: branches,
            tooltip: {
                y: {
                    formatter: function(val) {
                        return 'Rp ' + Math.round(val).toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                position: 'bottom'
            },
            colors: ['#5D87FF', '#49BEFF', '#13DEB9', '#FFAE1F', '#FA896B']
        };

        new ApexCharts(
            document.querySelector("#chartBranchSales"),
            options
        ).render();
    });
</script>