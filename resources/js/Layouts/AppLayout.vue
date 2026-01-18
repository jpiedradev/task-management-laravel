<script setup>
import {Link, router, usePage} from '@inertiajs/vue3'
import {computed, watch} from 'vue'
import {useToast} from 'primevue/usetoast'

import Menubar from 'primevue/menubar'
import Avatar from 'primevue/avatar'
import Button from 'primevue/button'
import Toast from 'primevue/toast'

const props = defineProps({
    title: String
})

const page = usePage()
const toast = useToast()

// Menu items
/*const items = [
    {
        label: 'Tareas',
        icon: 'pi pi-list',
        command: () => router.visit('/tasks')
    }
]*/

const logout = () => {
    router.post('logout')
}

// Mostrar mensajes flash automáticamente
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) {
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: flash.success,
                life: 3000
            })
        }

        if (flash?.error) {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: flash.error,
                life: 3000
            })
        }
    },
    {deep: true, immediate: true}
)
</script>

<template>
    <div>
        <Toast position="top-right"/>

        <!-- Header -->
        <Menubar :model="items">
            <template #start>
                <Link href="/tasks" style="text-decoration: none; color: inherit;">
                    <span style="font-weight: bold; font-size: 18px;">
                        📋 Task Manager
                    </span>
                </Link>
            </template>

            <template #end>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span>{{ $page.props.auth.user?.name }}</span>
                    <Avatar
                        :label="$page.props.auth.user?.name?.charAt(0)"
                        shape="circle"
                        style="background-color: #8b5cf6; color: white;"
                    />
                    <Button
                        label="Salir"
                        icon="pi pi-sign-out"
                        severity="secondary"
                        @click="logout"
                    />
                </div>
            </template>
        </Menubar>

        <!-- Contenido -->
        <div style="padding: 40px; max-width: 1400px; margin: 0 auto;">
            <h1 v-if="title" style="margin-bottom: 30px;">{{ title }}</h1>
            <slot/>
        </div>
    </div>
</template>

<style>
body {
    margin: 0;
    background: #f9fafb;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}
</style>
