<script setup>
const props = defineProps({
    datas: Object,
    cdata: Object,
    title: String,
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
    };

    var chart = new google.visualization.PieChart(
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
