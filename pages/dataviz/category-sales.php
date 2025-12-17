<?php
$query = "
    SELECT
        p.product_category AS category,
        COUNT(*) AS trx_count
    FROM fact_sales fs
    JOIN product p ON fs.id_product = p.id_product
    GROUP BY p.product_category
    ORDER BY trx_count DESC
    LIMIT 10
";

$result = $conn->query($query);

$categories = [];
$trxCount   = [];

while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'] ?? 'Unknown';
    $trxCount[]   = (int)$row['trx_count'];
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="fw-semibold mb-2">Transaksi per Kategori Produk</h4>
            <p class="text-muted mb-4">Menampilkan jumlah transaksi berdasarkan kategori produk.</p>

            <div id="chartCategorySales"></div>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        const categories = ['Elektronik', 'Fashion', 'Makanan', 'Kesehatan', 'Rumah Tangga'];
        const trxCount = [240, 180, 320, 110, 150];

        var options = {
            chart: {
                type: 'bar',
                height: 340,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Jumlah Transaksi',
                data: trxCount
            }],
            xaxis: {
                categories,
                title: {
                    text: 'Kategori'
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Transaksi'
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%'
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => val + ' transaksi'
                }
            },
            grid: {
                strokeDashArray: 4
            },
            colors: ['#FFAE1F']
        };

        new ApexCharts(document.querySelector("#chartCategorySales"), options).render();
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ambil dari PHP (bukan dummy)
        const categories = <?= json_encode($categories, JSON_UNESCAPED_UNICODE); ?>;
        const trxCount = <?= json_encode($trxCount); ?>;

        const options = {
            chart: {
                type: 'bar',
                height: 340,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Jumlah Transaksi',
                data: trxCount
            }],
            xaxis: {
                categories: categories,
                title: {
                    text: 'Kategori'
                },
                labels: {
                    rotate: -35,
                    trim: true
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Transaksi'
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%'
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: (val) => val + ' transaksi'
                }
            },
            grid: {
                strokeDashArray: 4
            },
            colors: ['#FFAE1F']
        };

        new ApexCharts(document.querySelector("#chartCategorySales"), options).render();
    });
</script>