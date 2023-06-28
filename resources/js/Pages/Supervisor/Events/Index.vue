<script setup>
import SupervisorLayout from "@/Layouts/SupervisorLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";

const form = useForm();
const props = defineProps({
    events: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    can: Array
});
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("supervisor.events.destroy", id));
    }
}
</script>
<template>
    <Head title="Event Page" />

    <SupervisorLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <Link :href="route('supervisor.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('supervisor.events.index')" :only="['events']"> Event </Link>
                </li>
            </ol>
        </template>
        <div class="container">
            <div class="text-right" v-if="HrHandler||SuperAdmin">
                <Link :href="route('supervisor.events.create')" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-plus"></i> New Event
                </Link>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Event</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Attachment</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="(event, index) in events.data"
                                :key="event.id"
                            >
                                <th scope="row">{{ ++index }}</th>
                                <td scope="row">{{ event.title }}</td>
                                <td scope="row">{{ event.start_date }}</td>
                                <td scope="row">{{ event.end_date }}</td>
                                <td scope="row"><a :href="event.document_url" target="_blank">Open Document</a></td>
                                <td scope="row">
                                    <div class="btn-group" v-if="HrHandler||SuperAdmin">
                                        <Link :href="route('supervisor.events.show', event.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                        <Link :href="route('supervisor.events.edit', event.id)"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </Link>
                                        <button
                                            class="btn btn-sm btn-outline-danger"
                                            @click="destroy(event.id)"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" v-else>
                                        <Link :href="route('supervisor.events.show', event.id)"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="8">
                                    <Pagination class="mt-6" :links="events.links" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </SupervisorLayout>
</template>
