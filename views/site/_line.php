<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div id="line-chart"></div>
                <!-- <img id="jpg-export"></img> -->
                <div class="row">
                    <div class="col-sm-6 result-card">
                        <div class="value">
                            <p>Rz1</p>
                            <p></p>
                        </div>
                        <div class="value">
                            <p>Rz2</p>
                            <p></p>
                        </div>
                        <div class="value">
                            <p>Rz3</p>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('line-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var stConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Static Line',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
            xaxis: {
                title: "Length (m)"
            },
            yaxis: {
                rangemode: 'tozero',
                zeroline: true,
                title: "Displacement (m)"
            }
        };

        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        // var img_jpg = document.getElementById('jpg-export');
        Plotly.plot( stDiv, stData, stLayout, stConfig );
            /*.then(
                function(gd) {
                    Plotly.toImage(gd, { height:650, width:1290 })
                        .then(
                            function(url) {
                                img_jpg.src = url;
                                return Plotly.toImage(gd, { format:'png', height:650, width:1290 });
                            })
                });*/
    </script>
</div>
