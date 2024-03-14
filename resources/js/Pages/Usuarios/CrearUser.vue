<template>
    <div class="flex justify-center items-center h-screen">
      <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-96">
        <h2 class="text-2xl mb-4">Crear Usuario</h2>
        <form @submit.prevent="guardarUsuario" novalidate>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">Nombre:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" v-model="usuario.name" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" v-model="usuario.email" required>
            <p v-if="!validarEmail(usuario.email)" class="text-red-500 text-xs italic">Por favor, introduce un correo electrónico válido.</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Contraseña:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" v-model="usuario.password" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirmarPassword">Confirmar Contraseña:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="confirmarPassword" type="password" v-model="confirmarPassword" required>
            <p v-if="confirmarPassword !== usuario.password" class="text-red-500 text-xs italic">Las contraseñas no coinciden.</p>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="rol">Rol:</label>
            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="rol" v-model="usuario.rol">
              <option value="admin">Admin</option>
              <option value="student">Student</option>
            </select>
          </div>
          <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Guardar</button>
            <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" @click="regresar">Regresar</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  
  const { csrfToken } = defineProps({
    csrfToken: String
  });
  
  const usuario = ref({
    name: '',
    email: '',
    password: '',
    rol: 'student' 
  });
  
  const confirmarPassword = ref('');
  
  // Función para limpiar los campos del formulario
  const limpiarCampos = () => {
    usuario.value.name = '';
    usuario.value.email = '';
    usuario.value.password = '';
    confirmarPassword.value = '';
  };
  
  const guardarUsuario = async () => {
    try {
      if (!csrfToken) {
        console.error('El token CSRF no está disponible en este momento.');
        return;
      }
  
      // Verificar si el formulario es válido antes de enviar
      if (!validarFormulario()) {
        return;
      }
  
      const response = await fetch('guardar-usuarios', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrfToken,
        },
        body: JSON.stringify(usuario.value)
      });
  
      debugger;
      if (response.ok) {
        const data = await response.json();
        mostrarMensaje("Registro guardado con éxito","success");
  
        limpiarCampos();

        router.get('ver-usuarios');
      } else {
        console.error('Error en la solicitud:', response.statusText);
       
        alert("Error en la solicitud" , response.statusText);
      }
    } catch (error) {
      console.error('Error al guardar el usuario:', error);
      alert('Error al guardar el usuario');
    }
  };
  
  const regresar = () => {
    router.get('dashboard');
  };
  
  const validarEmail = (email) => {
    // Validar el formato de correo electrónico
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };
  
  const validarFormulario = () => {
    // Validar que todos los campos requeridos estén completos
    if (!usuario.value.name || !usuario.value.email || !usuario.value.password || !confirmarPassword.value) {
      alert('Por favor completa todos los campos.');
      return false;
    }
    
    // Validar el formato de correo electrónico
    if (!validarEmail(usuario.value.email)) {
      alert('Por favor introduce un correo electrónico válido.');
      return false;
    }
    
    // Validar que las contraseñas coincidan
    if (confirmarPassword.value !== usuario.value.password) {
      alert('Las contraseñas no coinciden.');
      return false;
    }
    
    return true;
  };
  
  const mostrarMensaje = (tipo, mensaje) => {
    if (tipo === 'success') {
      alert(mensaje); // Puedes cambiar esto por tu implementación de mensajes de éxito
    } else if (tipo === 'error') {
      alert(mensaje); // Puedes cambiar esto por tu implementación de mensajes de error
    }
  };
  </script>
  
  <style scoped>

.alert-success {
  background-color: #d4edda;
  border-color: #c3e6cb;
  color: #155724;
  padding: .75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: .25rem;
}

.alert-error {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  color: #721c24;
  padding: .75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: .25rem;
}
</style>
  