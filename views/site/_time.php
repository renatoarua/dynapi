<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div id="time-chart"></div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('time-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var stConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Time Response',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            scene: {
                zaxis: {
                    range: [-40000, 40000]
                },
                aspectratio: {
                    x:3,
                    y:1,
                    z:1
                }
            }
        };
        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        var stFrames = <?= json_encode($model['frames']) ?>;


        Plotly.plot( stDiv, {
            data: stData,
            layout: stLayout,
            frames: stFrames,
            config: stConfig
        });
    </script>
</div>
