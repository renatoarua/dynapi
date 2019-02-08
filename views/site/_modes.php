<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <span></span>
        </div>
        <div class="card-body">
            <div>
                <div id="modes-chart"></div>
                <div class="row">
			      <div class="col-sm-6 form-group">
			        <label>Spin Speed</label>
			        <!-- <select id="frequency" class="form-control select-primary" (change)="onChange($event.target.value)">
			          <option *ngFor="let freq of _modes" [value]="freq.value" [selected]="">{{freq.label}}</option>
			        </select> -->
			      </div>
			    </div>
            </div>
        </div>
    </div>
    <script>
        var stDiv = document.getElementById('modes-chart');

        var stData = <?= json_encode($model['data']) ?>;
        var stConfig = {
            displayModeBar: false,
            displaylogo: false
        };

        var stLayout = {
            height: 650,
            title: 'Natural Modes of Vibration',
            paper_bgcolor: 'transparent',
            plot_bgcolor: 'transparent',
            font: {
                size: 14,
                color: '#4de2ff'
            },
			scene: {
				aspectmode: 'manual',
				aspectratio: {
					x:3,
					y:1,
					z:1
				}
			}
        };

        Object.assign(stLayout, <?= json_encode($model['layout']) ?>);
        Plotly.plot( stDiv, stData, stLayout, stConfig );
    </script>
</div>
