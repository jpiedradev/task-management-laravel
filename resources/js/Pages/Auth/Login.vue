<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'
import Message from 'primevue/message'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div style="width: 100%; max-width: 450px; padding: 20px;">

            <!-- Logo y título -->
            <div style="text-align: center; margin-bottom: 30px;">
                <div style="font-size: 48px; margin-bottom: 10px;">📋</div>
                <h1 style="margin: 0; color: white; font-size: 32px; font-weight: bold;">
                    Task Manager
                </h1>
                <p style="margin: 10px 0 0 0; color: rgba(255,255,255,0.9);">
                    Inicia sesión para continuar
                </p>
            </div>

            <!-- Card del formulario -->
            <Card>
                <template #content>
                    <!-- Mensaje de status -->
                    <Message v-if="status" severity="success" :closable="false" style="margin-bottom: 20px;">
                        {{ status }}
                    </Message>

                    <form @submit.prevent="submit">
                        <div style="display: flex; flex-direction: column; gap: 20px;">

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
                                    autofocus
                                    autocomplete="username"
                                />
                                <small v-if="form.errors.email" style="color: #dc2626; display: block; margin-top: 5px;">
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
                                    :feedback="false"
                                    toggleMask
                                    placeholder="Tu contraseña"
                                    inputStyle="width: 100%"
                                    style="width: 100%;"
                                    :inputClass="{ 'p-invalid': form.errors.password }"
                                    autocomplete="current-password"
                                />
                                <small v-if="form.errors.password" style="color: #dc2626; display: block; margin-top: 5px;">
                                    {{ form.errors.password }}
                                </small>
                            </div>

                            <!-- Remember me -->
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <Checkbox
                                    v-model="form.remember"
                                    inputId="remember"
                                    :binary="true"
                                />
                                <label for="remember" style="cursor: pointer; user-select: none;">
                                    Recordarme
                                </label>
                            </div>

                            <!-- Botón submit -->
                            <Button
                                type="submit"
                                label="Iniciar Sesión"
                                icon="pi pi-sign-in"
                                style="width: 100%;"
                                :loading="form.processing"
                            />

                            <!-- Links -->
                            <div style="display: flex; flex-direction: column; gap: 10px; align-items: center; font-size: 14px;">
                                <Link
                                    v-if="canResetPassword"
                                    href="/forgot-password"
                                    style="color: #667eea; text-decoration: none;"
                                >
                                    ¿Olvidaste tu contraseña?
                                </Link>

                                <div style="color: #6b7280;">
                                    ¿No tienes cuenta?
                                    <Link
                                        href="/register"
                                        style="color: #667eea; text-decoration: none; font-weight: 500;"
                                    >
                                        Regístrate
                                    </Link>
                                </div>
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
