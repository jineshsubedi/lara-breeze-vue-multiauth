<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'nav-link block active'
    : 'nav-link block '
);
</script>

<template>
    <Link :href="href" :class="classes" as="href" style="cursor:pointer;">
        <slot />
    </Link>
</template>
