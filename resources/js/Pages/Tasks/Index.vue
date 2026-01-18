<script setup>
import {ref, computed} from 'vue'
import {router, useForm} from '@inertiajs/vue3'
import {useToast} from 'primevue/usetoast'
import {useConfirm} from 'primevue/useconfirm'
import AppLayout from '@/Layouts/AppLayout.vue'

import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Dropdown from 'primevue/dropdown'
import Tag from 'primevue/tag'
import Card from 'primevue/card'
import Dialog from 'primevue/dialog'
import ConfirmDialog from 'primevue/confirmdialog'

const toast = useToast()
const confirm = useConfirm()

// Props recibidos desde Laravel
const props = defineProps({
    tasks: Array,
    stats: Object,
    filters: Object
})

// Estado de los modales
const createModalVisible = ref(false)
const editModalVisible = ref(false)
const taskToEdit = ref(null)

// Filtros locales
const search = ref(props.filters?.search || '')
const status = ref(props.filters?.status || '')
const order = ref(props.filters?.order || 'latest')

// Opciones
const statusOptions = [
    {label: 'Todos', value: ''},
    {label: 'Pendiente', value: 'pendiente'},
    {label: 'En Progreso', value: 'en_progreso'},
    {label: 'Completada', value: 'completada'}
]

const orderOptions = [
    {label: 'Más recientes', value: 'latest'},
    {label: 'Más antiguos', value: 'oldest'},
    {label: 'Título (A-Z)', value: 'title_asc'},
    {label: 'Título (Z-A)', value: 'title_desc'}
]

// Form para crear
const createForm = useForm({
    title: '',
    description: '',
    status: 'pendiente'
})

// Form para editar
const editForm = useForm({
    title: '',
    description: '',
    status: ''
})

// Métodos de filtros
const applyFilters = () => {
    router.get('/tasks', {
        search: search.value,
        status: status.value,
        order: order.value
    }, {
        preserveState: true,
        preserveScroll: true
    })
}

const clearFilters = () => {
    search.value = ''
    status.value = ''
    order.value = 'latest'
    router.get('/tasks')
}

// Métodos de modal crear
const openCreateModal = () => {
    createForm.reset()
    createForm.clearErrors()
    createModalVisible.value = true
}

const closeCreateModal = () => {
    createModalVisible.value = false
    createForm.reset()
}

const submitCreate = () => {
    createForm.post('/tasks', {
        preserveScroll: true,
        onSuccess: () => {
            closeCreateModal()
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: 'Tarea creada exitosamente',
                life: 3000
            })
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Revisa los errores en el formulario',
                life: 3000
            })
        }
    })
}

// Métodos de modal editar
const openEditModal = (task) => {
    taskToEdit.value = task
    editForm.title = task.title
    editForm.description = task.description
    editForm.status = task.status
    editForm.clearErrors()
    editModalVisible.value = true
}

const closeEditModal = () => {
    editModalVisible.value = false
    taskToEdit.value = null
    editForm.reset()
}

const submitEdit = () => {
    editForm.put(`/tasks/${taskToEdit.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeEditModal()
            toast.add({
                severity: 'success',
                summary: 'Éxito',
                detail: 'Tarea actualizada exitosamente',
                life: 3000
            })
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: 'Revisa los errores en el formulario',
                life: 3000
            })
        }
    })
}

// Método eliminar
const deleteTask = (task) => {
    confirm.require({
        message: `¿Estás seguro de eliminar "${task.title}"?`,
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sí, eliminar',
        rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => {
            router.delete(`/tasks/${task.id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Éxito',
                        detail: 'Tarea eliminada',
                        life: 3000
                    })
                }
            })
        }
    })
}

// Utilidades
const getSeverity = (status) => {
    switch (status) {
        case 'pendiente':
            return 'warn'
        case 'en_progreso':
            return 'info'
        case 'completada':
            return 'success'
        default:
            return null
    }
}

const getStatusLabel = (status) => {
    const option = statusOptions.find(opt => opt.value === status)
    return option?.label || status
}

const formatDate = (dateString) => {
    if (!dateString) return '-'
    const date = new Date(dateString)
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    })
}
</script>

<template>
    <AppLayout title="Gestión de Tareas">
        <Toast position="top-right" />
        <ConfirmDialog/>

        <!-- Estadísticas -->
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <Card>
                <template #content>
                    <div style="text-align: center;">
                        <div style="font-size: 48px; font-weight: bold; color: #8b5cf6; margin-bottom: 8px;">
                            {{ stats.total }}
                        </div>
                        <div style="color: #6b7280; font-size: 16px;">
                            Total de tareas
                        </div>
                    </div>
                </template>
            </Card>

            <Card>
                <template #content>
                    <div style="text-align: center;">
                        <div style="font-size: 48px; font-weight: bold; color: #f59e0b; margin-bottom: 8px;">
                            {{ stats.pendientes }}
                        </div>
                        <div style="color: #6b7280; font-size: 16px;">
                            Pendientes
                        </div>
                    </div>
                </template>
            </Card>

            <Card>
                <template #content>
                    <div style="text-align: center;">
                        <div style="font-size: 48px; font-weight: bold; color: #3b82f6; margin-bottom: 8px;">
                            {{ stats.en_progreso }}
                        </div>
                        <div style="color: #6b7280; font-size: 16px;">
                            En Progreso
                        </div>
                    </div>
                </template>
            </Card>

            <Card>
                <template #content>
                    <div style="text-align: center;">
                        <div style="font-size: 48px; font-weight: bold; color: #10b981; margin-bottom: 8px;">
                            {{ stats.completadas }}
                        </div>
                        <div style="color: #6b7280; font-size: 16px;">
                            Completadas
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <!-- Filtros -->
        <Card style="margin-bottom: 20px;">
            <template #content>
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto auto; gap: 15px; align-items: end;">
                    <div>
                        <label for="search" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Buscar por título
                        </label>
                        <InputText
                            id="search"
                            v-model="search"
                            placeholder="Escribe para buscar..."
                            style="width: 100%;"
                            @keyup.enter="applyFilters"
                        />
                    </div>

                    <div>
                        <label for="status" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Estado
                        </label>
                        <Dropdown
                            id="status"
                            v-model="status"
                            :options="statusOptions"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="Todos"
                            style="width: 100%;"
                        />
                    </div>

                    <div>
                        <label for="order" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Ordenar
                        </label>
                        <Dropdown
                            id="order"
                            v-model="order"
                            :options="orderOptions"
                            optionLabel="label"
                            optionValue="value"
                            style="width: 100%;"
                        />
                    </div>

                    <div>
                        <Button
                            label="Buscar"
                            icon="pi pi-search"
                            @click="applyFilters"
                        />
                    </div>

                    <div>
                        <Button
                            label="Limpiar"
                            icon="pi pi-filter-slash"
                            severity="secondary"
                            @click="clearFilters"
                        />
                    </div>
                </div>

                <div v-if="filters?.search || filters?.status"
                     style="margin-top: 15px; padding: 10px; background: #eff6ff; border-radius: 8px;">
                    <strong style="margin-right: 10px;">Filtros activos:</strong>
                    <Tag v-if="filters.search" :value="`Búsqueda: ${filters.search}`" style="margin-right: 5px;"/>
                    <Tag v-if="filters.status" :value="`Estado: ${getStatusLabel(filters.status)}`"/>
                </div>
            </template>
        </Card>

        <!-- Botón crear -->
        <div style="margin-bottom: 20px;">
            <Button
                label="Nueva Tarea"
                icon="pi pi-plus"
                severity="success"
                size="large"
                @click="openCreateModal"
            />
        </div>

        <!-- Tabla -->
        <Card>
            <template #content>
                <DataTable
                    :value="tasks"
                    :paginator="tasks.length > 10"
                    :rows="10"
                    :rowsPerPageOptions="[5, 10, 20, 50]"
                    stripedRows
                    responsiveLayout="scroll"
                >
                    <Column field="id" header="ID" sortable style="width: 80px;">
                        <template #body="slotProps">
                            <strong>#{{ slotProps.data.id }}</strong>
                        </template>
                    </Column>

                    <Column field="title" header="Título" sortable>
                        <template #body="slotProps">
                            <strong style="font-size: 15px;">
                                {{ slotProps.data.title }}
                            </strong>
                        </template>
                    </Column>

                    <Column field="description" header="Descripción">
                        <template #body="slotProps">
                            <span style="color: #6b7280;">
                                {{ slotProps.data.description || 'Sin descripción' }}
                            </span>
                        </template>
                    </Column>

                    <Column field="status" header="Estado" sortable style="width: 150px;">
                        <template #body="slotProps">
                            <Tag
                                :value="getStatusLabel(slotProps.data.status)"
                                :severity="getSeverity(slotProps.data.status)"
                            />
                        </template>
                    </Column>

                    <Column field="created_at" header="Fecha" sortable style="width: 180px;">
                        <template #body="slotProps">
                            <span style="color: #6b7280;">
                                {{ formatDate(slotProps.data.created_at) }}
                            </span>
                        </template>
                    </Column>

                    <Column header="Acciones" style="width: 180px;">
                        <template #body="slotProps">
                            <div style="display: flex; gap: 8px;">
                                <Button
                                    icon="pi pi-pencil"
                                    severity="info"
                                    size="small"
                                    @click="openEditModal(slotProps.data)"
                                    v-tooltip.top="'Editar'"
                                />
                                <Button
                                    icon="pi pi-trash"
                                    severity="danger"
                                    size="small"
                                    @click="deleteTask(slotProps.data)"
                                    v-tooltip.top="'Eliminar'"
                                />
                            </div>
                        </template>
                    </Column>

                    <template #empty>
                        <div style="text-align: center; padding: 60px 20px; color: #6b7280;">
                            <i class="pi pi-inbox"
                               style="font-size: 64px; margin-bottom: 20px; display: block; opacity: 0.5;"></i>

                            <div v-if="filters?.search || filters?.status">
                                <h3 style="margin: 0 0 10px 0;">No se encontraron tareas</h3>
                                <p style="margin: 0 0 20px 0;">Intenta con otros filtros</p>
                                <Button
                                    label="Limpiar filtros"
                                    icon="pi pi-filter-slash"
                                    severity="secondary"
                                    @click="clearFilters"
                                />
                            </div>

                            <div v-else>
                                <h3 style="margin: 0 0 10px 0;">No tienes tareas aún</h3>
                                <p style="margin: 0 0 20px 0;">¡Crea tu primera tarea para comenzar!</p>
                                <Button
                                    label="Crear tarea"
                                    icon="pi pi-plus"
                                    severity="success"
                                    @click="openCreateModal"
                                />
                            </div>
                        </div>
                    </template>
                </DataTable>
            </template>
        </Card>

        <!-- MODAL CREAR -->
        <Dialog
            v-model:visible="createModalVisible"
            modal
            header="Nueva Tarea"
            :style="{ width: '600px' }"
            :closable="!createForm.processing"
        >
            <form @submit.prevent="submitCreate">
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    <!-- Título -->
                    <div>
                        <label for="create-title" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Título <span style="color: red;">*</span>
                        </label>
                        <InputText
                            id="create-title"
                            v-model="createForm.title"
                            placeholder="Escribe el título de la tarea"
                            style="width: 100%;"
                            :class="{ 'p-invalid': createForm.errors.title }"
                            autofocus
                        />
                        <small v-if="createForm.errors.title" style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ createForm.errors.title }}
                        </small>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="create-description" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Descripción
                        </label>
                        <Textarea
                            id="create-description"
                            v-model="createForm.description"
                            rows="4"
                            placeholder="Escribe una descripción (opcional)"
                            style="width: 100%;"
                            :class="{ 'p-invalid': createForm.errors.description }"
                        />
                        <small v-if="createForm.errors.description"
                               style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ createForm.errors.description }}
                        </small>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="create-status" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Estado <span style="color: red;">*</span>
                        </label>
                        <Dropdown
                            id="create-status"
                            v-model="createForm.status"
                            :options="statusOptions.filter(opt => opt.value !== '')"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="Selecciona un estado"
                            style="width: 100%;"
                            :class="{ 'p-invalid': createForm.errors.status }"
                        />
                        <small v-if="createForm.errors.status" style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ createForm.errors.status }}
                        </small>
                    </div>
                </div>
            </form>

            <template #footer>
                <Button
                    label="Cancelar"
                    severity="secondary"
                    @click="closeCreateModal"
                    :disabled="createForm.processing"
                />
                <Button
                    label="Guardar"
                    icon="pi pi-check"
                    @click="submitCreate"
                    :loading="createForm.processing"
                />
            </template>
        </Dialog>

        <!-- MODAL EDITAR -->
        <Dialog
            v-model:visible="editModalVisible"
            modal
            :header="`Editar: ${taskToEdit?.title || ''}`"
            :style="{ width: '600px' }"
            :closable="!editForm.processing"
        >
            <form @submit.prevent="submitEdit" v-if="taskToEdit">
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    <!-- Título -->
                    <div>
                        <label for="edit-title" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Título <span style="color: red;">*</span>
                        </label>
                        <InputText
                            id="edit-title"
                            v-model="editForm.title"
                            placeholder="Escribe el título de la tarea"
                            style="width: 100%;"
                            :class="{ 'p-invalid': editForm.errors.title }"
                            autofocus
                        />
                        <small v-if="editForm.errors.title" style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ editForm.errors.title }}
                        </small>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="edit-description" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Descripción
                        </label>
                        <Textarea
                            id="edit-description"
                            v-model="editForm.description"
                            rows="4"
                            placeholder="Escribe una descripción (opcional)"
                            style="width: 100%;"
                            :class="{ 'p-invalid': editForm.errors.description }"
                        />
                        <small v-if="editForm.errors.description"
                               style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ editForm.errors.description }}
                        </small>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="edit-status" style="display: block; margin-bottom: 8px; font-weight: 500;">
                            Estado <span style="color: red;">*</span>
                        </label>
                        <Dropdown
                            id="edit-status"
                            v-model="editForm.status"
                            :options="statusOptions.filter(opt => opt.value !== '')"
                            optionLabel="label"
                            optionValue="value"
                            placeholder="Selecciona un estado"
                            style="width: 100%;"
                            :class="{ 'p-invalid': editForm.errors.status }"
                        />
                        <small v-if="editForm.errors.status" style="color: #dc2626; display: block; margin-top: 5px;">
                            {{ editForm.errors.status }}
                        </small>
                    </div>

                    <!-- Info -->
                    <div
                        style="padding: 12px; background: #f3f4f6; border-radius: 6px; font-size: 14px; color: #6b7280;">
                        <div style="margin-bottom: 5px;">
                            <strong>ID:</strong> #{{ taskToEdit.id }}
                        </div>
                        <div>
                            <strong>Creada:</strong> {{ formatDate(taskToEdit.created_at) }}
                        </div>
                    </div>
                </div>
            </form>

            <template #footer>
                <Button
                    label="Cancelar"
                    severity="secondary"
                    @click="closeEditModal"
                    :disabled="editForm.processing"
                />
                <Button
                    label="Actualizar"
                    icon="pi pi-check"
                    @click="submitEdit"
                    :loading="editForm.processing"
                />
            </template>
        </Dialog>
    </AppLayout>
</template>
