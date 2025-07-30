<template>
    <v-layout>
        <v-app-bar :elevation="2" color="orange">
            <v-app-bar-title>Application</v-app-bar-title>
        </v-app-bar>
        <v-main>
            <slot />
        </v-main>
    </v-layout>
</template>