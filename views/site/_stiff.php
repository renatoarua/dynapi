<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div id="stiffness-chart"></div>
            </div>
            <div>
                <div id="stiffness-cut-chart"></div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label>Rotations</label>
                    <!-- <select class="form-control select-primary" id="rotations">
                      <option *ngFor="let freq of _rotations" [value]="freq.value" [selected]="">{{freq.label}}</option>
                    </select> -->
                  </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('stiffness-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var config = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Stiffness Map',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            scene: {
                xaxis: {
                    title: "Speed (rpm)",
                    gridcolor: 'rgb(255, 255, 255)'
                },
                yaxis: {
                    title: "Stiffness (N/m)",
                    gridcolor: 'rgb(255, 255, 255)',
                    type: 'log'
                },
                zaxis: {
                    title: "Natural Frequency (Hz)",
                    gridcolor: 'rgb(255, 255, 255)',
                },
                aspectratio: { 
                    x:1.5, y:2.5, z:0.7
                },
                aspectmode: 'manual'
            }
        };

        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        Plotly.plot( stDiv, stData, stLayout, stConfig );

        var ndDiv = document.getElementById('stiffness-cut-chart');

        var ndData = <?= json_encode($model2['data']) ?>;
        var ndConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var ndLayout = {
            height: 650,
            title: 'Stiffness Cut - 2D',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Stiffness (N/m)",
                type: "log"
            },
            yaxis: {
                rangemode: 'tozero',
                zeroline: true,
                title: "Natural Frequency (Hz)"
            }
        };
        Object.assign(ndLayout, <?= json_encode($model2['layout']) ?>);
        Plotly.plot( ndDiv, ndData, ndLayout, ndConfig );
    </script>
</div>
