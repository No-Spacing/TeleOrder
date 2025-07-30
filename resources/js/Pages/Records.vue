<script setup>
import { ref, watch } from 'vue'
import Layout from "../Layout/Main.vue"
import { router, useForm } from '@inertiajs/vue3' 

defineProps({
    records: Object
})

const search = ref('');
const loading = ref(false);

watch(search, (value) => {
    router.get('/records', {
        search: value,
    },
    {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
        }
    });
})

function viewto(value){
    router.post('/view-to',
        {
            id: value
        },
        {
            onSuccess: () => {
                loading.value = false
            }
        }
    )
}

function approve(value){
    loading.value = true
    router.post('/submit-approve',{
        id: value
    },
    {
        onSuccess: () => {
            loading.value = false
        }
    })
}

function decline(value){
    loading.value = true
    router.post('/submit-decline',{
        id:value
    },
    {
        onSuccess: () => {
            loading.value = false
        }
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
                                    <th class="text-left">
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
                                    <td>
                                        <v-btn class="mx-2" @click="viewto(record.id)">
                                            View
                                        </v-btn>
                                        <v-btn class="mx-2" @click="approve(record.id)" :loading="loading">
                                            Approve
                                        </v-btn>
                                        <v-btn class="mx-2" @click="decline(record.id)" :loading="loading"> 
                                            Decline
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                </v-container>
            </v-card>
        </v-container>
    </Layout>
</template>