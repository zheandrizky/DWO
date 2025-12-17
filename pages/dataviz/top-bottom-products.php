<?php
// pastikan $conn sudah ada
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

$topProducts = [];
$topValues   = [];
while ($row = $topRes->fetch_assoc()) {
  $topProducts[] = $row['product'];
  $topValues[]   = (float)$row['total_sales'];
}

$bottomProducts = [];
$bottomValues   = [];
while ($row = $bottomRes->fetch_assoc()) {
  $bottomProducts[] = $row['product'];
  $bottomValues[]   = (float)$row['total_sales'];
}
?>

<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-start justify-content-between">
        <div>
          <h4 class="fw-semibold mb-1">Top & Bottom Products</h4>
          <p class="text-muted mb-0">Pilih Top 5 atau Bottom 5 pada periode 5 tahun terakhir.</p>
        </div>

        <select id="tbMode" class="form-select form-select-sm" style="width: 150px;">
          <option value="top" selected>Top 5</option>
          <option value="bottom">Bottom 5</option>
        </select>
      </div>

      <div class="mt-4" id="chartTopBottom"></div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const dataTop = {
    products: <?= json_encode($topProducts, JSON_UNESCAPED_UNICODE) ?>,
    values: <?= json_encode($topValues) ?>
  };

  const dataBottom = {
    products: <?= json_encode($bottomProducts, JSON_UNESCAPED_UNICODE) ?>,
    values: <?= json_encode($bottomValues) ?>
  };

  const rupiah = (val) => 'Rp ' + Math.round(val).toLocaleString('id-ID');

  // default tampil TOP
  let current = dataTop;

  const options = {
    chart: {
      type: 'bar',
      height: 360,
      toolbar: { show: false }
    },
    series: [{
      name: 'Sales (Rp)',
      data: current.values
    }],
    xaxis: {
      categories: current.products,
      title: { text: 'Produk' }
    },
    yaxis: {
      title: { text: 'Sales (Rp)' },
      labels: { formatter: rupiah }
    },
    plotOptions: {
      bar: {
        borderRadius: 6,
        columnWidth: '55%'
      }
    },
    tooltip: {
      y: { formatter: rupiah }
    },
    grid: { strokeDashArray: 4 }
  };

  const chart = new ApexCharts(document.querySelector("#chartTopBottom"), options);
  chart.render();

  // ganti mode top/bottom
  document.getElementById('tbMode').addEventListener('change', async function () {
    current = (this.value === 'bottom') ? dataBottom : dataTop;

    // kalau dataset kosong, jangan bikin chart “kosong” tanpa info
    if (!current.values || current.values.length === 0) {
      await chart.updateOptions({
        xaxis: { categories: [] },
        series: [{ name: 'Sales (Rp)', data: [] }]
      });
      return;
    }

    await chart.updateOptions({
      xaxis: { categories: current.products },
      series: [{ name: 'Sales (Rp)', data: current.values }]
    });
  });
});
</script>
