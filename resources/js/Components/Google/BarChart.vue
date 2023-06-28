<script setup>
const props = defineProps({
    datas: Object,
    cdata: Object,
    title: String,
    hAxis: String,
    vAxis: String,
    id: String,
});
google.charts.load("current", { packages: ["corechart", "bar"] });
google.charts.setOnLoadCallback(drawBarColors);

function drawBarColors() {
    var cdata = [];
    cdata.push(props.cdata);
    for (var i = 0; i < props.datas.length; i++) {
        cdata.push([props.datas[i][0], props.datas[i][1]]);
    }
    var data = google.visualization.arrayToDataTable(cdata);

    var options = {
        title: props.title,
        chartArea: { width: "50%" },
        colors: ["#b0120a", "#ffab91"],
        hAxis: {
            title: props.hAxis,
            minValue: 0,
        },
        vAxis: {
            title: props.vAxis,
        },
    };
    var chart = new google.visualization.BarChart(
        document.getElementById(props.id)
    );
    chart.draw(data, options);
}
</script>
<template>
    <div class="mt-3">
        <div
            :id="id"
            style="max-height: 500px"
        ></div>
    </div>
</template>
