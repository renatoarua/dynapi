<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div id="campbell-chart"></div>
            </div>
            <div>
                <div id="instabilities-chart"></div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('campbell-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var stConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Campbell Diagram',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Speed (rpm)"
            },
            yaxis: {
                rangemode: 'tozero',
                zeroline: true,
                title: "Natural Frequency (Hz)"
            }
        };

        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        Plotly.plot( stDiv, stData, stLayout, stConfig );

        var ndDiv = document.getElementById('instabilities-chart');

        var ndData = <?= json_encode($model2['data']) ?>;
        var ndConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var ndLayout = {
            height: 650,
            title: 'Instability Map',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Speed (rpm)"
            },
            yaxis: {
                rangemode: 'tozero',
                zeroline: true,
                title: "Eigenvalues (real part)"
            }
        };
        Object.assign(ndLayout, <?= json_encode($model2['layout']) ?>);
        Plotly.plot( ndDiv, ndData, ndLayout, ndConfig );
    </script>
</div>
