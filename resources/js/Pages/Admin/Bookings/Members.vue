<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    booking: Object,
    staffs: Object
})

const form = useForm();

const staffForm = useForm({
    booking_id: props.booking.id,
    category: [{'staff_id' : ''}],
});
function addCategory()
{
    staffForm.category.push({'staff_id' : ''});
}
function removeCategory(index)
{
    staffForm.category.splice(index, 1)
}

function destroy(id) {
    if (confirm("Are you sure you want to Remove")) {
        form.delete(route("admin.bookings.removeParticipants", id));
    }
}
</script>
<template>
    <Head title="Booking Participants" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Booking Participants
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.bookings.index')"> Booking </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.bookings.getParticipants', booking.id)"> Participants </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Booking Participants</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(staff, sin) in booking.staffs" :key="sin">
                                        <td>{{++sin}}</td>
                                        <td>{{staff.user ? staff.user.name : ''}}</td>
                                        <td><span v-html="staff.status_label"></span></td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                @click="destroy(staff.id)"
                                                v-if="booking.booked_by == $page.props.auth.user.id && staff.status == '0'"
                                            >
                                                <i class="bi bi-x-lg"></i> Remove
                                            </button>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <h5 class="card-title">Add Participants</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    staffForm.post(route('admin.bookings.saveParticipants', booking.id))
                                "
                            >
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Staff</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(st, index) in staffForm.category" :key="index">
                                            <td>
                                                <select v-model="staffForm.category[index].staff_id" class="form-control" required>
                                                    <option v-for="(staff, sindex) in staffs" :key="sindex" :value="staff.id">{{ staff.name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeCategory(index)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <div colspan="3" class="text-danger" v-for="(form) in form.errors">
                                                    {{form}}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="addCategory"><i class="bi bi-plus"></i>  Add More</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="form-group row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button
                                            type="submit"
                                            class="btn btn-outline-primary btn-sm"
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
