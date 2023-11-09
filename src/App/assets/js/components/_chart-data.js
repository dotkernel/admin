window.chart = require('chart.js');
import Chart from 'chart.js/auto';

var randomScalingFactor = function () {
    return Math.round(Math.random() * 1000)
};

var lineChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
datasets: [
    {
        label: "My First dataset",
        tension: 0.4,
        fill: true,
        backgroundColor: "rgba(81,45,168,0.1)",
        borderColor: "rgba(81,45,168)",
        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    },
    {
        label: "My Second dataset",
        tension: 0.4,
        fill: true,
        backgroundColor: "rgba(25,118,210,0.1)",
        borderColor: "rgba(25,118,210)",
        data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
    }]

};

var barChartData = {
    labels: ["January", "February", "March", "April", "May", "June", "July"],
    datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        },
        {
            label: "My Second dataset",
            fillColor: "rgba(48, 164, 255, 0.2)",
            strokeColor: "rgba(48, 164, 255, 0.8)",
            highlightFill: "rgba(48, 164, 255, 0.75)",
            highlightStroke: "rgba(48, 164, 255, 1)",
            data: [randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor(), randomScalingFactor()]
        }
    ]

};

var pieData = [
    {
        value: 300,
        color: "#30a5ff",
        highlight: "#62b9fb",
        label: "Blue"
    },
    {
        value: 50,
        color: "#ffb53e",
        highlight: "#fac878",
        label: "Orange"
    },
    {
        value: 100,
        color: "#1ebfae",
        highlight: "#3cdfce",
        label: "Teal"
    },
    {
        value: 120,
        color: "#f9243f",
        highlight: "#f6495f",
        label: "Red"
    }

];

var doughnutData = [
    {
        value: 300,
        color: "#30a5ff",
        highlight: "#62b9fb",
        label: "Blue"
    },
    {
        value: 50,
        color: "#ffb53e",
        highlight: "#fac878",
        label: "Orange"
    },
    {
        value: 100,
        color: "#1ebfae",
        highlight: "#3cdfce",
        label: "Teal"
    },
    {
        value: 120,
        color: "#f9243f",
        highlight: "#f6495f",
        label: "Red"
    }

];

window.onload = function () {
    var chart1 = document.getElementById("line-chart");
    if (chart1) {
        chart1 = chart1.getContext("2d");
        var mychart = new Chart(chart1, {
            type: 'line',
            data: lineChartData
        });
    }

    var chart2 = document.getElementById("bar-chart");
    if (chart2) {
        chart2 = chart2.getContext("2d");
         var mychart = new Chart(chart2, {
                    type: 'bar',
                    data: barChartData
                });
    }
};

    /*var chart2 = document.getElementById("bar-chart").getContext("2d");
     window.myBar = new Chart(chart2).Bar(barChartData, {
     responsive: true
     });
     var chart3 = document.getElementById("doughnut-chart").getContext("2d");
     window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {
     responsive: true
     });
     var chart4 = document.getElementById("pie-chart").getContext("2d");
     window.myPie = new Chart(chart4).Pie(pieData, {
     responsive: true
     });*/
