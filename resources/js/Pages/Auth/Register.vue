<script setup>
import {useForm} from '@inertiajs/vue3'
import {Link} from '@inertiajs/vue3'

import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <div
        style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 20px 0;">
        <div style="width: 100%; max-width: 450px; padding: 20px;">

            <!-- Logo y título -->
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="font-size: 48px; margin-bottom: 10px;">📋</div>
                <h1 style="margin: 0; color: white; font-size: 32px; font-weight: bold;">
                    Task Manager
                </h1>
                <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9);">
                    Crea tu cuenta
                </p>
            </div>

            <!-- Card del formulario -->
            <Card>
                <template #content>
                    <form @submit.prevent="submit">
                        <div style="display: flex; flex-direction: column; gap: 20px;">

                            <!-- Nombre -->
                            <div>
                                <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500;">
                                    Nombre completo
                                </label>
                                <InputText
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Johan Piedra"
                                    style="width: 100%;"
                                    :class="{ 'p-invalid': form.errors.name }"
                                    autofocus
                                    autocomplete="name"
                                />
                                <small v-if="form.errors.name" style="color: #dc2626; display: block; margin-top: 5px;">
                                    {{ form.errors.name }}
                                </small>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500;">
                                    Email
                                </label>
                                <InputText
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="correo@ejemplo.com"
                                    style="width: 100%;"
                                    :class="{ 'p-invalid': form.errors.email }"
                                    autocomplete="username"
                                />
                                <small v-if="form.errors.email"
                                       style="color: #dc2626; display: block; margin-top: 5px;">
                                    {{ form.errors.email }}
                                </small>
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" style="display: block; margin-bottom: 8px; font-weight: 500;">
                                    Contraseña
                                </label>
                                <Password
                                    id="password"
                                    v-model="form.password"
                                    toggleMask
                                    placeholder="Mínimo 8 caracteres"
                                    inputStyle="width: 100%"
                                    style="width: 100%;"
                                    :inputClass="{ 'p-invalid': form.errors.password }"
                                    autocomplete="new-password"
                                    :pt="{
                                        meter: { style: 'display: none' }
                                    }"
                                />
                                <small v-if="form.errors.password"
                                       style="color: #dc2626; display: block; margin-top: 5px;">
                                    {{ form.errors.password }}
                                </small>
                            </div>

                            <!-- Confirmar Password -->
                            <div>
                                <label for="password_confirmation"
                                       style="display: block; margin-bottom: 8px; font-weight: 500;">
                                    Confirmar contraseña
                                </label>
                                <Password
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    :feedback="false"
                                    toggleMask
                                    placeholder="Repite tu contraseña"
                                    inputStyle="width: 100%"
                                    style="width: 100%;"
                                    :inputClass="{ 'p-invalid': form.errors.password_confirmation }"
                                    autocomplete="new-password"
                                />
                                <small v-if="form.errors.password_confirmation"
                                       style="color: #dc2626; display: block; margin-top: 5px;">
                                    {{ form.errors.password_confirmation }}
                                </small>
                            </div>

                            <!-- Botón submit -->
                            <Button
                                type="submit"
                                label="Crear Cuenta"
                                icon="pi pi-user-plus"
                                style="width: 100%;"
                                :loading="form.processing"
                            />

                            <!-- Link a login -->
                            <div style="text-align: center; font-size: 14px; color: #6b7280;">
                                ¿Ya tienes cuenta?
                                <Link
                                    href="/login"
                                    style="color: #667eea; text-decoration: none; font-weight: 500;"
                                >
                                    Inicia sesión
                                </Link>
                            </div>
                        </div>
                    </form>
                </template>
            </Card>

            <!-- Footer -->
            <div style="text-align: center; margin-top: 20px; color: rgba(255,255,255,0.8); font-size: 14px;">
                © 2025 Task Manager. Todos los derechos reservados.
            </div>
        </div>
    </div>
</template>
