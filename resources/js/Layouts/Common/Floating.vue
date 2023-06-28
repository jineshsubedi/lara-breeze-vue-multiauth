<script setup>
let MessengerMenu = Ziggy.routes['messenger'] ? true : false;
</script>

<template>
    <div class="fab-container" v-if="MessengerMenu">
        <div class="btn-float">
            <a
                href="/messenger"
                class="btn btn-default btn-circle btn-xl btn-lateral"
                target="_blank"
            >
                <i class="bi bi-chat-dots"></i></a
            ><br />
        </div>
    </div>
</template>
<style scoped>
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
.btn-circle.btn-lg { 
    width: 50px;
    height: 50px;
    padding: 10px 16px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 25px;
}
.btn-circle.btn-xl {
    width: 60px;
    height: 60px;
    padding: 15px 15px;
    font-size: 24px;
    line-height: 1.33;
    border-radius: 35px;
}

.btn-float {
    position: fixed;
    right: 37px;
    bottom: 100px;
}

.btn-lateral {
    background-color: #4fb0dd7a;
    color: white;
    margin: 10px;
}
.btn-lateral:hover {
    background-color: #4fb0dd;
}

.btn-filter {
    background-color: #283896;
    color: #fff;
}
</style>
