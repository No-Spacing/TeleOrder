<script setup>
import { ref } from 'vue'
import Layout from "../../Layout/Main.vue"
import { router, useForm, usePage } from '@inertiajs/vue3' 
import { watchDebounced } from "@vueuse/core";

defineProps({
    records: Object
})

const page = usePage();
const search = ref('');
const loading = ref(false);
const declineDialog = ref(false);
const snackbar = ref(false);

const form = useForm({
    id: null,
    code_id: null,
    type: null,
    credit_limit: null,
    cl_balance: null,
    order_taken_by: null,
})

watchDebounced(search, (value) => {
    router.get('/records', {
        search: value,
        page: page.props.records.current_page
    },
    {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
        }
    });
},{ debounce: 500, maxWait: 5000 })

function viewTO(id, code_id){
    // router.post('/view-to',{
    //     id: id,
    //     code_id: code_id,
    // })

    loading.value = true;
    axios.post('/view-to', {
        id: id,
        code_id: code_id,
    }, {
        responseType: 'blob',
    })
    .then((response) => {
        const fileURL = window.URL.createObjectURL(new Blob([response.data], { type: 'application/pdf' }));
        window.open(fileURL); // Opens in a new tab
        loading.value = false;
    })
    .catch((error) => {
        console.error('PDF generation failed:', error);
        loading.value = false;
    });
}

function approve(value){
    loading.value = true
    router.post('/submit-approve',{
        id: value
    },
    {
        onSuccess: () => {
            loading.value = false;
            snackbar.value = true;
        }
    })
}

function openDeclineDialog(value){
    declineDialog.value = true;
    form.id = value;
}

function submitDecline(){
    router.post('/submit-decline',form,
    {
        onSuccess: () => {
            loading.value = false
        }
    })
}

function paginations(){
    router.get('/records', {
        search: search.value,
        page: page.props.records.current_page
    }, {
        preserveState: true,
        replace: true
    })
}
</script>
<template>
    <Layout>
        <v-container fluid>
            <v-card variant="outlined">
                <v-container fluid>
                    <v-text-field v-model="search" variant="outlined" label="Search"></v-text-field>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    T.O No.
                                </th>
                                <th class="text-left">
                                    Customer Code
                                </th>
                                <th class="text-left">
                                    Sold To
                                </th>
                                <th class="text-left">
                                    Order Date
                                </th>
                                <th class="text-left">
                                    Payment Terms
                                </th>
                                <th class="text-left">
                                    Status
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="record in records.data">
                                <td>{{ record.teleorder_date + record.teleorder_no }}</td>
                                <td>{{ record.code.code }}</td>
                                <td>{{ record.code.customer.customer }}</td>
                                <td>{{ record.order_date }}</td>
                                <td>{{ record.paymentTerms }}</td>
                                <td>{{ record.status }}</td>
                                <td class="">
                                    <v-btn class="mx-2" color="blue" @click="viewTO(record.id, record.code_id)" :loading="loading">
                                        View
                                    </v-btn>
                                    <v-btn class="mx-2" color="green" @click="approve(record.id)" :loading="loading" v-if="record.status == 'Pending'">
                                        Approve
                                    </v-btn>
                                    <v-btn class="mx-2" color="red" @click="openDeclineDialog(record.id)" :loading="loading" v-if="record.status == 'Pending'"> 
                                        Decline
                                    </v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                    <v-pagination
                        v-model="records.current_page" 
                        :length="records.last_page"
                        @update:modelValue="paginations"
                    ></v-pagination>
                </v-container>
            </v-card>
        </v-container>
        <v-dialog
            v-model="declineDialog"
            width="auto"
        >
            <v-card
                width="600"
                title="Reasons for Rejection"
            >
                <v-form @submit.prevent="submitDecline">
                    <v-card-text>
                        <v-select
                            v-model="form.type"
                            :items="['OVER CREDIT LIMIT', 'HOLD ACCOUNT', 'CANCELLED']"
                            label="Select"
                            variant="outlined"
                        ></v-select>

                        <v-text-field
                            v-model="form.credit_limit"
                            label="Credit Limit"
                            variant="outlined"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.cl_balance"
                            label="C.L. Balance"
                            variant="outlined"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.order_taken_by"
                            label="Order Taken By"
                            variant="outlined"
                        ></v-text-field>

                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn
                            text="Cancel"
                            variant="outlined"
                            @click="declineDialog = false"
                        ></v-btn>
                        <v-btn
                            text="Submit"
                            variant="outlined"
                            type="submit"
                        ></v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
        <v-snackbar
            v-model="snackbar"
            :timeout="2000"
            color="success"
            location="top"
        >
            {{ $page.props.flash.message }}
        </v-snackbar>
    </Layout>
</template>