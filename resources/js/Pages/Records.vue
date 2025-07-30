<script setup>
import Layout from "../Layout/Main.vue"

defineProps({
    records: Object
})
</script>
<template>
    <Layout>
        <v-container fluid>
            <v-card variant="outlined">
                <v-container fluid>
                    <v-text-field variant="outlined" label="Search"></v-text-field>
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
                                <tr>
                                    <td>TO. 12345</td>
                                    <td>CO123</td>
                                    <td>Test Project</td>
                                    <td>2025/07/30</td>
                                    <td>Cash</td>
                                    <td>Pending</td>
                                    <td>
                                        <v-btn class="mx-2">
                                            View
                                        </v-btn>
                                        <v-btn class="mx-2">
                                            Approve
                                        </v-btn>
                                        <v-btn class="mx-2">
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