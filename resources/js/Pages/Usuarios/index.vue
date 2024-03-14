<template>
    <AppLayout >
      <div class="container mx-auto px-4 py-8">
        <!-- Botones -->
        <div class="flex justify-end mb-4">
          <!-- Botón para regresar al dashboard -->
          <button class="bg-gray-500 text-white px-4 py-2 rounded shadow mr-4" @click="regresarDashboard">Regresar</button>
          <!-- Botón para agregar usuarios -->
          <button class="bg-blue-500 text-white px-4 py-2 rounded shadow" @click="mostrarFormularioAgregarUsuario">Agregar Usuarios</button>
        </div>
  
        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto">
          <table v-if="mostrarTabla" class="mt-4 w-full table-auto">
            <thead>
              <tr class="bg-gray-100">
                <th class="py-2 px-4 border border-gray-200">ID</th>
                <th class="py-2 px-4 border border-gray-200">Nombre</th>
                <th class="py-2 px-4 border border-gray-200">Email</th>
                <th class="py-2 px-4 border border-gray-200">Rol</th>
                <th class="py-2 px-4 border border-gray-200">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <!-- Iterar sobre los usuarios y mostrarlos en la tabla -->
              <tr v-for="usuario in users" :key="usuario.id">
                <td class="py-2 px-4 border border-gray-200">{{ usuario.id }}</td>
                <td class="py-2 px-4 border border-gray-200">{{ usuario.name }}</td>
                <td class="py-2 px-4 border border-gray-200">{{ usuario.email }}</td>
                <td class="py-2 px-4 border border-gray-200">{{ usuario.role }}</td>
                <td class="py-2 px-4 border border-gray-200">
                  <!-- Botón de editar para cada usuario -->
                  <button class="bg-blue-500 text-white px-2 py-1 rounded shadow" @click="editarUsuario(usuario)">Editar</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </AppLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Head, router } from '@inertiajs/vue3';

  
  defineProps({
    title: String,
    users: Array
  });
  
  // Estado para controlar la visibilidad de la tabla
  const mostrarTabla = ref(true);
  
  // Método para mostrar el formulario de agregar usuario
  const mostrarFormularioAgregarUsuario = () => {

    router.get('crear-usuarios');

  };
  
  // Método para editar un usuario
  const editarUsuario = (usuario) => {
    // Agregar lógica para editar un usuario
  };
  
  // Función para regresar al dashboard
  const regresarDashboard = () => {
    router.get('dashboard');
  };
  
  
  
  </script>
  