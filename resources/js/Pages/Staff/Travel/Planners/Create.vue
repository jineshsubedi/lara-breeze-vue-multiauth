<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    travels: Object,
    departments: Object,
    staffs: Object,
});

const form = useForm({
    travel_id: null,
    user_id: null,
    department_id: null,

    itinery: [
        {
            date: "",
            travel_from: "",
            travel_to: "",
            time_from: "",
            time_to: "",
        },
    ],
    road: [
        {
            vehicle_number: "",
            driver_name: "",
            driver_number: "",
            vendor_name: "",
            bus_number: "",
        },
    ],
    air: [
        {
            flight_number: "",
            airline_name: "",
            departure_on: "",
            arrival_on: "",
        },
    ],
    hotel: [
        {
            hotel_name: "",
            hotel_number: "",
            departure_at: "",
            arrival_at: "",
            place: "",
            district: "",
        },
    ],
});
function addItinery() {
    form.itinery.push({
        date: "",
        travel_from: "",
        travel_to: "",
        time_from: "",
        time_to: "",
    });
}
function removeItinery(index) {
    form.itinery.splice(index, 1);
}
function addRoad() {
    form.road.push({
        vehicle_number: "",
        driver_name: "",
        driver_number: "",
        vendor_name: "",
        bus_number: "",
    });
}
function removeRoad(index) {
    form.road.splice(index, 1);
}
function addAir() {
    form.air.push({
        flight_number: "",
        airline_name: "",
        departure_on: "",
        arrival_on: "",
    });
}
function removeAir(index) {
    form.air.splice(index, 1);
}
function addHotel() {
    form.hotel.push({
        hotel_name: "",
        hotel_number: "",
        departure_at: "",
        arrival_at: "",
        place: "",
        district: "",
    });
}
function removeHotel(index) {
    form.hotel.splice(index, 1);
}
</script>
<template>
    <Head title="TravelPlanner Create" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                TravelPlanner Create
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.travelplanners.index')">
                        TravelPlanner
                    </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.travelplanners.create')">
                        Create
                    </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">New TravelPlanner</h5>
                            <form
                                class="form-horizontal"
                                @submit.prevent="
                                    form.post(
                                        route('staffs.travelplanners.store')
                                    )
                                "
                            >
                                <div class="form-group row mb-3">
                                    <label
                                        for="travel_id"
                                        class="col-sm-2 col-form-label"
                                        >Travel</label
                                    >
                                    <div class="col-sm-10">
                                        <select
                                            v-model="form.travel_id"
                                            class="form-control"
                                            id="travel_id"
                                        >
                                            <option
                                                v-for="(
                                                    travel, tindex
                                                ) in travels"
                                                :key="tindex"
                                                :value="travel.id"
                                            >
                                                {{ travel.unique_id }} ({{
                                                    travel.from
                                                }}
                                                - {{ travel.to }})
                                            </option>
                                        </select>
                                        <div
                                            class="text-red-400 text-sm"
                                            v-if="form.errors.travel_id"
                                        >
                                            {{ form.errors.travel_id }}
                                        </div>
                                    </div>
                                </div>
                                <h4 class="box-title">Ininery Information</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Date</th>
                                            <th colspan="2">Travel</th>
                                            <th colspan="2">Time</th>
                                            <th rowspan="2">Description</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>From</th>
                                            <th>To</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(st, index) in form.itinery"
                                            :key="index"
                                        >
                                            <td>
                                                <input
                                                    type="date"
                                                    v-model="
                                                        form.itinery[index].date
                                                    "
                                                    class="form-control"
                                                    placeholder="city"
                                                    required
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.itinery[index]
                                                            .travel_from
                                                    "
                                                    class="form-control"
                                                    placeholder="city"
                                                    required
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.itinery[index]
                                                            .travel_to
                                                    "
                                                    class="form-control"
                                                    placeholder="city"
                                                    required
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="time"
                                                    v-model="
                                                        form.itinery[index]
                                                            .time_from
                                                    "
                                                    class="form-control"
                                                    placeholder="city"
                                                    required
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="time"
                                                    v-model="
                                                        form.itinery[index]
                                                            .time_to
                                                    "
                                                    class="form-control"
                                                    placeholder="city"
                                                    required
                                                />
                                            </td>
                                            <td>
                                                <textarea
                                                    v-model="
                                                        form.itinery[index]
                                                            .description
                                                    "
                                                    id="description"
                                                    class="form-control"
                                                ></textarea>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="
                                                        removeItinery(index)
                                                    "
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div
                                                    class="text-danger"
                                                    v-for="form in form.errors
                                                        .itinery"
                                                >
                                                    {{ form.errors.itinery }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="addItinery()"
                                                >
                                                    <i class="bi bi-plus"></i>
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="box-title">Road Information</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Vehicle Number</th>
                                            <th>Driver Name</th>
                                            <th>Driver Number</th>
                                            <th>Vendor Name</th>
                                            <th>Public Bus</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(st, index) in form.road"
                                            :key="index"
                                        >
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.road[index]
                                                            .vehicle_number
                                                    "
                                                    class="form-control"
                                                    placeholder="Self/Company/Rental/Public"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.road[index]
                                                            .driver_name
                                                    "
                                                    class="form-control"
                                                    placeholder="Company/Rental Owner"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.road[index]
                                                            .driver_number
                                                    "
                                                    class="form-control"
                                                    placeholder="Company/Rental Owner"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.road[index]
                                                            .vendor_name
                                                    "
                                                    class="form-control"
                                                    placeholder="Rental Owner"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.road[index]
                                                            .bus_number
                                                    "
                                                    class="form-control"
                                                    placeholder="Public Bus Number"
                                                />
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="removeRoad(index)"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div
                                                    class="text-danger"
                                                    v-for="form in form.errors
                                                        .road"
                                                >
                                                    {{ form.errors.road }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="addRoad()"
                                                >
                                                    <i class="bi bi-plus"></i>
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="box-title">Air Information</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>FLight Number</th>
                                            <th>Airline Name</th>
                                            <th>Departure On</th>
                                            <th>Arrival On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(st, index) in form.air"
                                            :key="index"
                                        >
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.air[index]
                                                            .flight_number
                                                    "
                                                    class="form-control"
                                                    placeholder="Flight Number "
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.air[index]
                                                            .airline_name
                                                    "
                                                    class="form-control"
                                                    placeholder="Airline Name"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="date"
                                                    v-model="
                                                        form.air[index]
                                                            .departure_on
                                                    "
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="date"
                                                    v-model="
                                                        form.air[index]
                                                            .arrival_on
                                                    "
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="removeAir(index)"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <div
                                                    class="text-danger"
                                                    v-for="form in form.errors
                                                        .air"
                                                >
                                                    {{ form.errors.air }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="addAir()"
                                                >
                                                    <i class="bi bi-plus"></i>
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <h4 class="box-title">Hotel Booking</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Hotel Name</th>
                                            <th>Hotel Number</th>
                                            <th>Place</th>
                                            <th>District</th>
                                            <th>Arrival</th>
                                            <th>Departure</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(st, index) in form.hotel"
                                            :key="index"
                                        >
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.hotel[index]
                                                            .hotel_name
                                                    "
                                                    class="form-control"
                                                    placeholder="Hotel Name"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.hotel[index]
                                                            .hotel_number
                                                    "
                                                    class="form-control"
                                                    placeholder="Hotel Number"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.hotel[index].place
                                                    "
                                                    class="form-control"
                                                    placeholder="Address"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="text"
                                                    v-model="
                                                        form.hotel[index]
                                                            .district
                                                    "
                                                    class="form-control"
                                                    placeholder="District/State"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="date"
                                                    v-model="
                                                        form.hotel[index]
                                                            .arrival_at
                                                    "
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <input
                                                    type="date"
                                                    v-model="
                                                        form.hotel[index]
                                                            .departure_at
                                                    "
                                                    class="form-control"
                                                />
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="removeHotel(index)"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div
                                                    class="text-danger"
                                                    v-for="form in form.errors
                                                        .hotel"
                                                >
                                                    {{ form.errors.hotel }}
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    @click="addHotel()"
                                                >
                                                    <i class="bi bi-plus"></i>
                                                    Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div id="visaSection">
                                    <h4 class="box-title">Visa Processing (International Travel)</h4>
                                    <div class="row form-group">
                                        <div
                                            class="col-md-4"
                                            style="
                                                padding: 5px;
                                                margin-top: 5px;
                                            "
                                        >
                                            <label
                                                >Submitted Passport for the VISA
                                                processing
                                            </label>
                                        </div>
                                        <div
                                            class="col-md-4"
                                            style="
                                                padding: 5px;
                                                margin-top: 5px;
                                            "
                                        >
                                            <select
                                                v-model="form.department_id"
                                                id="department_id"
                                                class="form-control select2"
                                            >
                                                <option
                                                    v-for="(
                                                        department, dindex
                                                    ) in departments"
                                                    :key="dindex"
                                                    :value="department.id"
                                                >
                                                    {{ department.title }}
                                                </option>
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.department_id"
                                            >
                                                {{ form.errors.department_id }}
                                            </div>
                                        </div>
                                        <div
                                            class="col-md-4"
                                            style="
                                                padding: 5px;
                                                margin-top: 5px;
                                            "
                                        >
                                            <select
                                                v-model="form.user_id"
                                                id="staff_id"
                                                class="form-control select2"
                                            >
                                                <option
                                                    v-for="(
                                                        staff, sindex
                                                    ) in staffs"
                                                    :key="sindex"
                                                    :value="staff.id"
                                                >
                                                    {{ staff.name }}
                                                </option>
                                                @foreach($staffs as $staff)
                                            </select>
                                            <div
                                                class="text-red-400 text-sm"
                                                v-if="form.errors.user_id"
                                            >
                                                {{ form.errors.user_id }}
                                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StaffLayout>
</template>
