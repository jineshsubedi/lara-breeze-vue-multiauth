<script setup>
const props = defineProps({
    datas: Object,
    cdata: Object,
    title: String,
    hAxis: String,
    vAxis: String,
    id: String,
});
google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var cdata = [];
    cdata.push(props.cdata);
    for (var i = 0; i < props.datas.length; i++) {
        cdata.push([props.datas[i][0], props.datas[i][1]]);
    }
    var data = google.visualization.arrayToDataTable(cdata);

    var options = {
        title: props.title,
        hAxis: { title: props.hAxis },
        vAxis: { title: props.vAxis },
        legend: "none",
        trendlines: {
            0: {
                type: "polynomial",
                degree: 3,
                visibleInLegend: true,
            },
        }, // Draw a trendline for data series 0.
    };

    var chart = new google.visualization.ScatterChart(
        document.getElementById(props.id)
    );
    chart.draw(data, options);
}
</script>
<template>
    <div class="mt-3">
        <div :id="id" style="max-height: 500px"></div>
    </div>
</template>
