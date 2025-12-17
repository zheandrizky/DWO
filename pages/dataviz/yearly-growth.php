<?php

$sql = "
    SELECT 
        d.year,
        SUM(fs.total_revenue) AS total_revenue
    FROM fact_sales fs
    JOIN date d ON fs.id_date = d.id_date
    GROUP BY d.year
    ORDER BY d.year ASC
    LIMIT 5
";

$result = $conn->query($sql);

$years = [];
$revenues = [];

while ($row = $result->fetch_assoc()) {
    $years[] = (int)$row['year'];
    $revenues[] = (float)$row['total_revenue'];
}

$growth = [];

for ($i = 0; $i < count($revenues); $i++) {
    if ($i === 0) {
        $growth[] = null; 
    } else {
        if ($revenues[$i - 1] == 0) {
            $growth[] = null; 
        } else {
            $growth[] = (($revenues[$i] - $revenues[$i - 1]) / $revenues[$i - 1]) * 100;
        }
    }
}
?>


<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="fw-semibold mb-2">Growth Rate Tahunan</h4>
            <p class="text-muted mb-4">Persentase pertumbuhan revenue tiap tahun selama 5 tahun terakhir.</p>

            <div id="chartYearlyGrowth"></div>
        </div>
    </div>
</div>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const years = [2021, 2022, 2023, 2024, 2025];
        const growth = [null, 25, 16.7, -8.6, 31.3];

        var options = {
            chart: {
                type: 'line',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Growth (%)',
                data: growth
            }],
            xaxis: {
                categories: years,
                title: {
                    text: 'Tahun'
                }
            },
            yaxis: {
                title: {
                    text: 'Growth Rate (%)'
                },
                labels: {
                    formatter: (val) => (val === null ? '-' : val.toFixed(1) + '%')
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
                    formatter: (val) => val === null ? '-' : val.toFixed(1) + '%'
                }
            },
            grid: {
                strokeDashArray: 4
            },
            colors: ['#13DEB9']
        };

        new ApexCharts(document.querySelector("#chartYearlyGrowth"), options).render();
    });
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function() {

    const years = <?= json_encode($years) ?>;
    const growth = <?= json_encode($growth) ?>;

    var options = {
        chart: {
            type: 'line',
            height: 320,
            toolbar: { show: false }
        },
        series: [{
            name: 'Growth (%)',
            data: growth
        }],
        xaxis: {
            categories: years,
            title: { text: 'Tahun' }
        },
        yaxis: {
            title: { text: 'Growth Rate (%)' },
            labels: {
                formatter: function (val) {
                    return val === null ? '-' : val.toFixed(1) + '%';
                }
            }
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        markers: {
            size: 5
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val === null ? '-' : val.toFixed(1) + '%';
                }
            }
        },
        grid: {
            strokeDashArray: 4
        },
        colors: ['#13DEB9']
    };

    new ApexCharts(
        document.querySelector("#chartYearlyGrowth"),
        options
    ).render();
});
</script>
