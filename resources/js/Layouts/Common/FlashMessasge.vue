<script setup>
    import ToastNotification from "@/Components/ToastNotification.vue";
    let success = 'success';
    let danger = 'danger';
    let warning = 'warning';
    let info = 'info';
</script>

<template>
    <div  v-if="$page.props.flash.success">
        <ToastNotification :message = "$page.props.flash.success" :type="success"   />
    </div>
    <div  v-if="$page.props.flash.danger">
        <ToastNotification :message = "$page.props.flash.danger" :type="danger"   />
    </div>
    <div  v-if="$page.props.flash.warning">
        <ToastNotification :message = "$page.props.flash.warning" :type="warning"   />
    </div>
    <div  v-if="$page.props.flash.info">
        <ToastNotification :message = "$page.props.flash.info" :type="info"   />
    </div>
</template>