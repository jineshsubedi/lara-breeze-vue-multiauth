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
google.charts.setOnLoadCallback(drawVisualization);

function drawVisualization() {
    var cdata = [];
    cdata.push(props.cdata);
    for (var i = 0; i < props.datas.length; i++) {
        var newData = [];
        for(var j = 0; j < props.datas[i].length; j++)
        {
            newData.push(props.datas[i][j]);
        }
        cdata.push(newData);
    }
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(cdata);

    var options = {
        title: props.title,
        vAxis: { title: props.vAxis },
        hAxis: { title: props.hAxis },
        seriesType: "bars",
        series: { 5: { type: "line" } },
    };

    var chart = new google.visualization.ComboChart(
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
