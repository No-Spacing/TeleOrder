<script setup>
import { ref } from 'vue'
import Layout from "../../Layout/Main.vue"
import { router, useForm, usePage } from '@inertiajs/vue3' 
import { watchDebounced } from "@vueuse/core";

defineProps({
    users: Object,
    roles: Object,
})

const page = usePage();

const search = ref('');
const loading = ref(false);

const snackbar = ref(false);

const addUserDialog = ref(false)
const editDialog = ref(false)

const form = useForm({
    name: null,
    email: null,
    password: null,
    role_id: null,
})

const formUpdate = useForm({
    id: null,
    name: null,
    email: null,
    password: null,
    role_id: null,
})

watchDebounced(search, (value) => {
    router.get('/users', {
        search: value,
        page: page.props.users.current_page
    },
    {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false
        }
    });
},{ debounce: 500, maxWait: 5000 })

function paginations(){
    router.get('/users', {
        search: search.value,
        page: page.props.users.current_page
    },{
        preserveState: true,
        replace: true
    })
}

function submit()
{
    form.post('/submit-user',
        {
            onSuccess: () => {
                snackbar.value = true;
                form.reset();
                addUserDialog.value = false;
            }
        }
    )
}

function openEditDialog(user)
{
    formUpdate.id = user.id,
    formUpdate.name = user.name;
    formUpdate.email = user.email;
    formUpdate.password = user.password;
    formUpdate.role_id = user.role_id;
    editDialog.value = true;
}

function submitUpdate()
{
    formUpdate.post('/submit-update',
        {
            onSuccess: () => {
                snackbar.value = true
            }
        }
    )
}
</script>
<template>
    <Layout>
        <v-container fluid>
            <v-card variant="outlined" title="Users">
                <v-container fluid>
                    <v-btn class="mb-3" color="green" @click="addUserDialog = true">Add User</v-btn>
                    <v-text-field v-model="search" variant="outlined" label="Search"></v-text-field>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="text-left">
                                    ID
                                </th>
                                <th class="text-left">
                                    Name
                                </th>
                                <th class="text-left">
                                    Email
                                </th>
                                <th class="text-left">
                                    Role
                                </th>
                                <th class="text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.role.role }}</td>
                                <td class="d-flex justify-center align-center">
                                    <v-btn class="mx-2" color="primary" @click="openEditDialog(user)">
                                        Edit
                                    </v-btn>
                                    <v-btn class="mx-2" color="red" :loading="loading"> 
                                        Delete
                                    </v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                    <v-pagination
                        v-model="users.current_page" 
                        :length="users.last_page"
                        @update:modelValue="paginations" 
                    ></v-pagination>
                </v-container>
            </v-card>
        </v-container>
        <v-dialog
            v-model="addUserDialog"
            width="600"
        >
            <v-card title="Add User">
                <form @submit.prevent="submit">
                    <v-card-text>
                        <v-text-field
                            v-model="form.name"
                            label="Name"
                            :error-messages="form.errors.name"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.email"
                            label="E-mail"
                            :error-messages="form.errors.email"
                        ></v-text-field>

                        <v-text-field
                            v-model="form.password"
                            label="Password"
                            type="password"
                            :error-messages="form.errors.password"
                        ></v-text-field>

                        <v-select
                            v-model="form.role_id"
                            :items="roles"
                            label="Select"
                            item-title="role"
                            item-value="id"
                            :error-messages="form.errors.role_id"
                        ></v-select>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn
                            class="me-4"
                            type="submit"
                            size="large"
                        >
                            submit
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="editDialog"
            width="600"
        >
            <v-card title="Edit User">
                <form @submit.prevent="submitUpdate">
                    <v-card-text>
                        <v-text-field
                            v-model="formUpdate.name"
                            label="Name"
                            :error-messages="formUpdate.errors.name"
                        ></v-text-field>

                        <v-text-field
                            v-model="formUpdate.email"
                            label="E-mail"
                            :error-messages="formUpdate.errors.email"
                        ></v-text-field>

                        <v-text-field
                            v-model="formUpdate.password"
                            label="Password"
                            type="password"
                            :error-messages="formUpdate.errors.password"
                        ></v-text-field>

                        <v-select
                            v-model="formUpdate.role_id"
                            :items="roles"
                            label="Select"
                            item-title="role"
                            item-value="id"
                            :error-messages="formUpdate.errors.role_id"
                        ></v-select>
                    </v-card-text>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn
                            class="me-4"
                            type="submit"
                            size="large"
                        >
                            submit
                        </v-btn>
                    </v-card-actions>
                </form>
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