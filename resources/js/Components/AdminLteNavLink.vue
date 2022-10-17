<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'nav-link'
    : 'nav-link collapsed'
);
</script>

<template>
    <Link :href="href" :class="classes" as="href" style="cursor:pointer;">
        <slot />
    </Link>
</template>
