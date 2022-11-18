<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import MapModal from "@/Layouts/Common/MapModal.vue";

const props = defineProps({
    attendance : Object,
    data : Object,
})

const form = useForm({
    in_time_reason: props.attendance.in_time_reason,
    out_time_reason: props.attendance.out_time_reason,
    in_away_location: props.attendance.in_away_location,
    out_away_location: props.attendance.out_away_location,
});
const form2 = useForm({
    position: {lat: 51.093048, lng: 6.842120},
});
function showModal(path, location)
{
    var data = location.split(',');
    form2.position.lat = data[0];
    form2.position.lng = data[1];

    $('#'+path).modal('show');
}
</script>
<template>
    <Head title="Attendance Detail" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Attendance Detail
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('admin.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('admin.attendances.index')"> Attendance </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('admin.attendances.show', attendance.id)"> Detail </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Attendance Detail Information</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Attendance Date</th>
                                        <td>{{attendance.attendance_date}}</td>
                                    </tr>
                                    <tr>
                                        <th>Staff</th>
                                        <td>{{attendance.user ? attendance.user.name : ''}}</td>
                                    </tr>
                                    <tr>
                                        <th>In Time</th>
                                        <td>
                                            <div v-if="attendance.in_time != null">
                                            <button :class="attendance.in_time_class"  @click="showModal('duty-In'+index, attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.in_time}} {{attendance.in_time_distance}}</button>
                                            <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.in_time" :location="attendance.in_location" :key="'duty-In'+index" />
                                        </div>
                                        </td>
                                    </tr>
                                    <tr v-if="attendance.in_time_reason != null">
                                        <th>Late Clock In Reason</th>
                                        <td>{{attendance.in_time_reason}}</td>
                                    </tr>
                                    <tr v-if="attendance.in_away_location != null">
                                        <th>Away Clock In Reason</th>
                                        <td>{{attendance.in_away_location}}</td>
                                    </tr>
                                    <tr>
                                        <th>Lunch Start</th>
                                        <td>
                                            <div v-if="attendance.lunch_start != null">
                                            <button :class="attendance.lunch_start_class"  @click="showModal('duty-In'+index, attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.lunch_start}} {{attendance.lunch_start_distance}}</button>
                                            <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.lunch_start" :location="attendance.in_location" :key="'duty-In'+index" />
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lunch End</th>
                                        <td>
                                            <div v-if="attendance.lunch_end != null">
                                            <button :class="attendance.lunch_end_class"  @click="showModal('duty-In'+index, attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.lunch_end}} {{attendance.lunch_end_distance}}</button>
                                            <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.lunch_end" :location="attendance.in_location" :key="'duty-In'+index" />
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Out Time</th>
                                        <td>
                                            <div v-if="attendance.out_time != null">
                                            <button :class="attendance.out_time_class"  @click="showModal('duty-In'+index, attendance.in_location)"><i class="bi bi-geo-alt"></i> {{attendance.out_time}} {{attendance.out_time_distance}}</button>
                                            <MapModal :path="'duty-In'+index" :title="'Duty Start At: '+attendance.out_time" :location="attendance.in_location" :key="'duty-In'+index" />
                                        </div>
                                        </td>
                                    </tr>
                                    <tr v-if="attendance.out_time_reason != null">
                                        <th>Early Clock Out Reason</th>
                                        <td>{{attendance.out_time_reason}}</td>
                                    </tr>
                                    <tr v-if="attendance.out_away_location != null">
                                        <th>Away Clock Out Reason</th>
                                        <td>{{attendance.out_away_location}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Duration</th>
                                        <td>{{attendance.attendance_duration}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><p v-html="attendance.approve_title"></p></td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="data.late_clock_in || data.away_clock_in || data.away_clock_out || data.early_clock_out">
                                    <tr>
                                        <td colspan="2">
                                            <form
                                                class="form-horizontal"
                                                @submit.prevent="
                                                    form.put(route('admin.attendances.update', attendance.id))
                                                "
                                            >
                                                <div class="form-group row mb-3" v-if="attendance.in_time_reason == null && data.late_clock_in">
                                                    <label
                                                        for="intimereason"
                                                        class="col-sm-2 col-form-label"
                                                        >Late Clock In Response</label
                                                    >
                                                    <div class="col-sm-10">
                                                        <textarea v-model="form.in_time_reason" id="intimereason" class="form-control" rows="3" placeholder="Late Clock In Response" required></textarea>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="form.errors.in_time_reason"
                                                        >
                                                            {{ form.errors.in_time_reason }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3" v-if="attendance.out_time_reason == null && attendance.out_time != null && data.early_clock_out">
                                                    <label
                                                        for="outtimereason"
                                                        class="col-sm-2 col-form-label"
                                                        >Early Clock Out Response</label
                                                    >
                                                    <div class="col-sm-10">
                                                        <textarea v-model="form.out_time_reason" id="outtimereason" class="form-control" rows="3" placeholder="Early Clock Out Response" required></textarea>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="form.errors.out_time_reason"
                                                        >
                                                            {{ form.errors.out_time_reason }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3" v-if="attendance.in_away_location == null && data.away_clock_in">
                                                    <label
                                                        for="inawayreason"
                                                        class="col-sm-2 col-form-label"
                                                        >Away Clock In Response</label
                                                    >
                                                    <div class="col-sm-10">
                                                        <textarea v-model="form.in_away_location" id="inawayreason" class="form-control" rows="3" placeholder="Away Clock In Response" required></textarea>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="form.errors.in_away_location"
                                                        >
                                                            {{ form.errors.in_away_location }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3" v-if="attendance.out_away_location == null && attendance.out_time != null && data.away_clock_out">
                                                    <label
                                                        for="inawayreason"
                                                        class="col-sm-2 col-form-label"
                                                        >Away Clock Out Response</label
                                                    >
                                                    <div class="col-sm-10">
                                                        <textarea v-model="form.out_away_location" id="inawayreason" class="form-control" rows="3" placeholder="Away Clock Out Response" required></textarea>
                                                        <div
                                                            class="text-red-400 text-sm"
                                                            v-if="form.errors.out_away_location"
                                                        >
                                                            {{ form.errors.out_away_location }}
                                                        </div>
                                                    </div>
                                                </div>
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
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
