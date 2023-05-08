// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx1 = document.getElementById("myLineChart1");
var myLineChart1 = new Chart(ctx1, {
  type: 'line',
  data: {
    datasets: [
	    {
	      data: [12, 19, 3, 5, 2, 3],
      	borderWidth: 1,
        backgroundColor: ["B7B1F7"]
    	},
		]
  },
  options: {
  	scales: {
    	yAxes: [{
        ticks: {
					reverse: false
        }
      }]
    }
  }
});
