<script setup>
import StaffLayout from "@/Layouts/StaffLayout.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import CenterModal from "@/Components/CenterModal.vue";
import CenterModal1 from "@/Components/CenterModal.vue";
import TravelChat from "./Chat.vue"

import { ref } from "vue";

const props = defineProps({
    travel: Object,
    planner: Object,
    expenses: Object,
    approval: Object,
    can: Array
})
let SuperAdmin = props.can.includes('SuperAdmin');
let HrHandler = props.can.includes('HrHandler');
let PayrollHandler = props.can.includes('PayrollHandler');

const form = useForm({});
const expenseForm = useForm({
    destination_id: null,
    type: props.travel.account_approval == 1 ? 2 : 1,
    ticket: 0.0,
    lodging: 0.0,
    breakfast: 0.0,
    lunch: 0.0,
    dinner: 0.0,
    phone: 0.0,
    local_conveyance: 0.0,
    others: 0.0,
    description: null,
})
const expenseexpenseForm = useForm({
    remarks: '',
    status: 0,
    type: null,
    travel_id: 0,
});

function openExpenseModal()
{
    $('#openExpenseModal').modal('show');
}
function closeExpenseModal()
{
    expenseForm.reset();
    $('#openExpenseModal').modal('hide');
}
function destroyExpense(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("staffs.travels.deleteTravelExpense", id), {
            preserveScroll: true
        });
    }
}
let exp = ref({});
function openExpenseDetailForm(expens)
{
    exp.value = expens;
    $('#openExpenseDetailForm').modal('show');
}

</script>
<template>
    <Head title="Travel Information" />

    <StaffLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Travel Information
            </h2>
        </template>
        <template #breadcrum>
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.dashboard')"> Home </Link>
                </li>
                <li class="breadcrumb-item">
                    <Link :href="route('staffs.travels.index')"> Travel </Link>
                </li>
                <li class="breadcrumb-item active">
                    <Link :href="route('staffs.travels.show', travel.id)"> Information </Link>
                </li>
            </ol>
        </template>
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Travel Information</h5>
                            <TravelChat 
                                :replies="travel.reply"
                                :count="travel.reply_count"
                                :travel_id="travel.id"
                            />
                            <div class="row">
                                <div class="col-md-5">
                                    <h5 class="card-title"><u>Personal Detail</u></h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{travel.assign_to ? travel.assign_to.name : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Department</th>
                                                <td>{{travel.assign_to ? travel.assign_to.name : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Designation</th>
                                                <td>{{travel.assign_to ? travel.assign_to.name : ''}}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h5 class="card-title"><u>Organization Detail</u></h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Assignment</th>
                                                <td>{{travel.assign_type ? travel.assign_type.title : ''}} - {{travel.assign_category ? travel.assign_category.title : ''}}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Mode</th>
                                                <td v-if="travel.payment_mode == 'reimbursement'">{{travel.payment_mode}} >> {{travel.reimbursement}}</td>
                                                <td v-else>
                                                    {{travel.payment_mode}} >> {{travel.position}} - {{travel.grade}} - {{travel.per_diem_amount}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-7">
                                    <h5 class="card-title"><u>Travel Detail</u></h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>Type</th>
                                                <td>{{travel.type}}</td>
                                            </tr>
                                            <tr>
                                                <th>Purpose</th>
                                                <td>{{travel.purpose}}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Date</th>
                                                <td>{{travel.from}}</td>
                                            </tr>
                                            <tr>
                                                <th>Arrival Date</th>
                                                <td>{{travel.to}}</td>
                                            </tr>
                                            <tr>
                                                <th>Mode Of Transport</th>
                                                <td>{{travel.mode_of_transport}} > {{travel.road_sub}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="mb-3 mt-3 row">
                                    <div class="col-md-3">
                                        <h5 class="card-title"><u>Supervisor</u></h5>
                                        <p>Status: <span v-html="travel.supervisor_action"></span> </p>
                                        <p>Remarks: <span v-html="travel.supervisor_remark"></span> </p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="card-title"><u>Account</u></h5>
                                        <p>Status: <span v-html="travel.account_action"></span> </p>
                                        <p>Remarks: <span v-html="travel.account_remark"></span> </p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="card-title"><u>HR</u></h5>
                                        <p>Status: <span v-html="travel.hr_action"></span> </p>
                                        <p>Remarks: <span v-html="travel.hr_remark"></span> </p>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="card-title"><u>Chairman</u></h5>
                                        <p>Status: <span v-html="travel.chairman_action"></span> </p>
                                        <p>Remarks: <span v-html="travel.chairman_remark"></span> </p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <Link :href="route('staffs.travelplanners.create')" class="btn btn-sm btn-outline-info" style="float:right" v-if="travel.assigned_to == $page.props.auth.user.id && !planner">
                                <i class="bi bi-plus"></i> Travel Planning
                            </Link>
                            <div class="mt-3" v-if="planner">
                                <div v-if="planner.itinery">
                                    <h5 class="card-title">Itinery Information</h5>
                                    <table class="table table-bordered table-strpied">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Date</th>
                                                <th colspan="2">Travel</th>
                                                <th colspan="2">Time</th>
                                                <th rowspan="2">Description</th>
                                            </tr>
                                            <tr>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>From</th>
                                                <th>To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(itinery, itindex) in planner.itinery" :key="itindex">
                                                <td>{{itinery.date}}</td>
                                                <td>{{itinery.travel_from}}</td>
                                                <td>{{itinery.travel_to}}</td>
                                                <td>{{itinery.time_from}}</td>
                                                <td>{{itinery.time_to}}</td>
                                                <td>{{itinery.description}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="planner.road">
                                    <h5 class="card-title">Road Information</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                             <tr>
                                                <th>Vehicle Number</th>
                                                <th>Driver Name</th>
                                                <th>Driver Number</th>
                                                <th>Vendor Name</th>
                                                <th>Bus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(road, rindex) in planner.road" :key="rindex">
                                                <td>{{road.vehicle_number}}</td>
                                                <td>{{road.driver_name}}</td>
                                                <td>{{road.driver_number}}</td>
                                                <td>{{road.vendor_name}}</td>
                                                <td>{{road.bus_number}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="planner.air">
                                    <h5 class="card-title">FLight Information</h5>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Airline Name</th>
                                                <th>Flight Number</th>
                                                <th>Departure On</th>
                                                <th>Arrival City</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(air, aindex) in planner.air" :key="aindex">
                                                <td>{{air.airline_name}}</td>
                                                <td>{{air.flight_number}}</td>
                                                <td>{{air.departure_on}}</td>
                                                <td>{{air.arrival_on}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="planner.hotel">
                                    <h5 class="card-title">Hotel Booking Information</h5>
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Hotel Name</th>
                                                <th>Hotel Number</th>
                                                <th>Place</th>
                                                <th>District</th>
                                                <th>Arrival Date</th>
                                                <th>Departure Date</th>
                                            </tr>
                                            <tr v-for="(hotel, hindex) in planner.hotel" :key="hindex">
                                                <td>{{hotel.name}}</td>
                                                <td>{{hotel.number}}</td>
                                                <td>{{hotel.place_name}}</td>
                                                <td>{{hotel.district}}</td>
                                                <td>{{hotel.arrival_at}}</td>
                                                <td>{{hotel.departure_at}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="planner.visa">
                                    <h5 class="card-title">Visa Information</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Submitted Passport for the VISA processing 
                                        </div>
                                        <div class="col-md-4">
                                            {{planner.visa.department ? planner.visa.department.title : ''}} 
                                        </div>
                                        <div class="col-md-4">
                                            {{ planner.visa.user ? planner.visa.user.name : '' }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button class="btn btn-sm btn-outline-primary" style="float:right" v-if="travel.assigned_to == $page.props.auth.user.id" @click="openExpenseModal()">
                                <i class="bi bi-plus"></i> Travel Expenses
                            </button>
                            <div class="mt-3" v-if="expenses">
                                <h5 class="card-title">Travel Expenses</h5>
                                <table class="table table-bordered table-strpied">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Destination</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(expense, eindex) in expenses" :key="eindex">
                                            <td>{{expense.date}}</td>
                                            <td>{{expense.destination ? expense.destination.from+' - '+expense.destination.to : ''}}</td>
                                            <td>{{expense.total}}</td>
                                            <td class="btn-group">
                                                <button
                                                    class="btn btn-sm btn-outline-danger"
                                                    @click="destroyExpense(expense.id)"
                                                    v-if="travel.assigned_to == $page.props.auth.user.id || travel.assigned_from == $page.props.auth.user.id"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-primary" @click="openExpenseDetailForm(expense)"><i class="bi bi-arrows-angle-expand"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <CenterModal
                id="openExpenseModal"
                title="Travel Expense Form (Total Amount with VAT & Taxes)"
            >
                <form
                    class="form-horizontal"
                    @submit.prevent="
                        expenseForm.post(route('staffs.travels.saveTravelExpense', travel.id), {
                            preserveScroll: true,
                            onSuccess: () => closeExpenseModal()
                        })
                    "
                >
                    <div class="form-group row mb-3">
                        <label
                            for="destination_id"
                            class="col-sm-4 col-form-label"
                            >Destination</label
                        >
                        <div class="col-sm-8">
                            <select
                                v-model="expenseForm.destination_id"
                                id="destination_id"
                                class="form-control"
                            >
                                <option
                                    v-for="(
                                        destination, dindex
                                    ) in travel.destination"
                                    :key="dindex"
                                    :value="destination.id"
                                >
                                    {{ destination.from }} - {{destination.to}}
                                </option>
                            </select>
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.destination_id"
                            >
                                {{ expenseForm.errors.destination_id }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="ticket"
                            class="col-sm-4 col-form-label"
                            >Transportation</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.ticket" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.ticket"
                            >
                                {{ expenseForm.errors.ticket }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="lodging"
                            class="col-sm-4 col-form-label"
                            >Accomodation</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.lodging" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.lodging"
                            >
                                {{ expenseForm.errors.lodging }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="breakfast"
                            class="col-sm-4 col-form-label"
                            >Breakfast</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.breakfast" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.breakfast"
                            >
                                {{ expenseForm.errors.breakfast }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="lunch"
                            class="col-sm-4 col-form-label"
                            >Lunch</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.lunch" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.lunch"
                            >
                                {{ expenseForm.errors.lunch }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="dinner"
                            class="col-sm-4 col-form-label"
                            >Dinner</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.dinner" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.dinner"
                            >
                                {{ expenseForm.errors.dinner }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="phone"
                            class="col-sm-4 col-form-label"
                            >Communication</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.phone" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.phone"
                            >
                                {{ expenseForm.errors.phone }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="local_conveyance"
                            class="col-sm-4 col-form-label"
                            >Local Conveyance</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.local_conveyance" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.local_conveyance"
                            >
                                {{ expenseForm.errors.local_conveyance }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="others"
                            class="col-sm-4 col-form-label"
                            >Other</label
                        >
                        <div class="col-sm-8">
                            <input type="number" step="any" v-model="expenseForm.others" class="form-control">
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.others"
                            >
                                {{ expenseForm.errors.others }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label
                            for="description"
                            class="col-sm-4 col-form-label"
                            >Description</label
                        >
                        <div class="col-sm-8">
                            <textarea rows="3" class="form-control" v-model="expenseForm.description"></textarea>
                            <div
                                class="text-red-400 text-sm"
                                v-if="expenseForm.errors.description"
                            >
                                {{ expenseForm.errors.description }}
                            </div>
                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-10">
                        <button
                            type="submit"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </CenterModal>
            <CenterModal1
                id="openExpenseDetailForm"
                title="Travel Expense Detail"
            >
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <td>{{exp.date}}</td>
                        </tr>
                        <tr>
                            <th>Destination</th>
                            <td>{{exp.destination ? exp.destination.from+' - '+exp.destination.to : ''}}</td>
                        </tr>
                        <tr>
                            <th>Transportation</th>
                            <td>{{exp.ticket}}</td>
                        </tr>
                        <tr>
                            <th>Accomodation</th>
                            <td>{{exp.lodging}}</td>
                        </tr>
                        <tr>
                            <th>Breakfast</th>
                            <td>{{exp.breakfast}}</td>
                        </tr>
                        <tr>
                            <th>Lunch</th>
                            <td>{{exp.lunch}}</td>
                        </tr>
                        <tr>
                            <th>Dinner</th>
                            <td>{{exp.dinner}}</td>
                        </tr>
                        <tr>
                            <th>Communication</th>
                            <td>{{exp.phone}}</td>
                        </tr>
                        <tr>
                            <th>Local Conveyance</th>
                            <td>{{exp.local_conveyance}}</td>
                        </tr>
                        <tr>
                            <th>Others</th>
                            <td>{{exp.others}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <td>{{exp.total}}</td>
                        </tr>
                    </tfoot>
                </table>
            </CenterModal1>
            
        </div>
    </StaffLayout>
</template>
