<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div class="row">
                  <div class="col-sm-6 result-card">
                    <?php
                        $coords = ['X', 'Z', '&theta;', '&psi;'];
                        foreach ($model['entry'] as $i => $entry): ?>
                        <div class="value">
                            <p>Response #<?= $i+1 ?> <span class="line" style="<?= 'background-color:'.$entry['color'].';' ?>"></span></p>
                            <p>measured at: <?= $entry['position'] ?> m</p>
                            <p>direction: <span><?= $coords[$entry['coord'] - 1]?></span></p>
                        </div>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div id="constant-chart"></div>
            </div>
            <div>
                <div id="constant-phase-chart"></div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('constant-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var stConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Constant Response',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Frequency (Hz)"
            },
            yaxis: {
                rangemode: "tozero",
                zeroline: true,
                title: "Displacement (um)",
                type: "log"
            }
        };

        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        Plotly.plot( stDiv, stData, stLayout, stConfig );

        var ndDiv = document.getElementById('constant-phase-chart');

        var ndData = <?= json_encode($model2['data']) ?>;
        var ndConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var ndLayout = {
            height: 650,
            title: <?= json_encode($model2['layout']['title']) ?>,
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Frequency (Hz)"
            },
            yaxis: {
                rangemode: 'tozero',
                zeroline: true,
                title: "Phase (º)",
                type: "linear"
            }
        };

        Object.assign(ndLayout, <?= json_encode($model2['layout']) ?>);
        Plotly.plot( ndDiv, ndData, ndLayout, ndConfig );
    </script>
</div>
