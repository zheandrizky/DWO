<?php
$sqlTop = "
  SELECT
    p.product_name AS product,
    SUM(fs.total_revenue) AS total_sales
  FROM fact_sales fs
  JOIN date d ON d.id_date = fs.id_date
  JOIN product p ON p.id_product = fs.id_product
  WHERE d.year >= (SELECT MAX(year) - 4 FROM date)
  GROUP BY p.product_name
  ORDER BY total_sales DESC
  LIMIT 5
";

$sqlBottom = "
  SELECT
    p.product_name AS product,
    SUM(fs.total_revenue) AS total_sales
  FROM fact_sales fs
  JOIN date d ON d.id_date = fs.id_date
  JOIN product p ON p.id_product = fs.id_product
  WHERE d.year >= (SELECT MAX(year) - 4 FROM date)
  GROUP BY p.product_name
  HAVING SUM(fs.total_revenue) > 0
  ORDER BY total_sales ASC
  LIMIT 5
";

$topRes = $conn->query($sqlTop);
$bottomRes = $conn->query($sqlBottom);

$products = [];
$values = [];

while ($row = $topRes->fetch_assoc()) {
    $products[] = 'TOP - ' . $row['product'];
    $values[] = (float) $row['total_sales'];
}
while ($row = $bottomRes->fetch_assoc()) {
    $products[] = 'BOTTOM - ' . $row['product'];
    $values[] = (float) $row['total_sales'];
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="fw-semibold mb-2">Top & Bottom Products</h4>
            <p class="text-muted mb-4">Produk dengan kontribusi penjualan tertinggi dan terendah pada periode tertentu.</p>

            <div id="chartTopBottom"></div>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {

        const products = ['Produk A', 'Produk B', 'Produk C', 'Produk D', 'Produk E', 'Produk X', 'Produk Y', 'Produk Z', 'Produk W', 'Produk V'];
        const values = [85, 80, 74, 68, 60, 12, 10, 9, 7, 5]; // misal dalam juta

        var options = {
            chart: {
                type: 'bar',
                height: 360,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Sales (Juta)',
                data: values
            }],
            xaxis: {
                categories: products,
                title: {
                    text: 'Produk'
                }
            },
            yaxis: {
                title: {
                    text: 'Sales (Juta)'
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%'
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => val + ' Juta'
                }
            },
            grid: {
                strokeDashArray: 4
            },
            colors: ['#FA896B']
        };

        new ApexCharts(document.querySelector("#chartTopBottom"), options).render();
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const products = <?= json_encode($products, JSON_UNESCAPED_UNICODE) ?>;
        const values = <?= json_encode($values) ?>;

        var options = {
            chart: {
                type: 'bar',
                height: 360,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Sales (Rp)',
                data: values
            }],
            xaxis: {
                categories: products,
                title: {
                    text: 'Produk'
                }
            },
            yaxis: {
                title: {
                    text: 'Sales (Rp)'
                },
                labels: {
                    formatter: (val) => 'Rp ' + Math.round(val).toLocaleString('id-ID')
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%'
                }
            },
            tooltip: {
                y: {
                    formatter: (val) => 'Rp ' + Math.round(val).toLocaleString('id-ID')
                }
            },
            grid: {
                strokeDashArray: 4
            }
        };

        new ApexCharts(document.querySelector("#chartTopBottom"), options).render();
    });
</script>