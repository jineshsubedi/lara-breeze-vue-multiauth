<script setup>
import SuccessToast from "./SuccessToast.vue";


</script>

<template>
    <div  v-if="$page.props.flash.success">
        <SuccessToast :message = "xgvsbchvbdvhbkdjfvhkabjh"/>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="$page.props.flash.danger">
        {{ $page.props.flash.danger }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="$page.props.flash.warning">
        {{ $page.props.flash.warning }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</template>