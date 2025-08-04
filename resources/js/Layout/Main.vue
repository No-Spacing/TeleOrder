<script setup>
import { usePage, Link } from "@inertiajs/vue3"

const page = usePage()

</script>
<template>
    <v-layout>
        <v-navigation-drawer
            v-if="$page.props.user.can.admin"
            expand-on-hover
            permanent
            rail
        >
            <v-list>
                <v-list-item
                    prepend-icon="mdi-account"
                    :subtitle="$page.props.user.email"
                    :title="$page.props.user.name"
                ></v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-receipt-text-edit-outline" title="Form" @click="$inertia.get('/form')"></v-list-item>
                <v-list-item prepend-icon="mdi-list-box-outline" title="Records" @click="$inertia.get('/records')"></v-list-item>
                <v-list-item prepend-icon="mdi-account-multiple" title="Users" @click="$inertia.get('/users')"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar :elevation="2" color="orange">
            <v-app-bar-title>Application</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn href="/logout">Logout</v-btn>
        </v-app-bar>
        <v-main>
            <slot />
        </v-main>
    </v-layout>
</template>