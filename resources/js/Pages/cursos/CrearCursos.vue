<template>
    <div class="flex justify-center items-center h-screen">
      <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-lg w-full">
        <h2 class="text-2xl mb-4 text-center">Creación de Curso</h2>
        <form @submit.prevent="submit" novalidate>
          <input type="hidden" name="_token" :value="csrfToken" /> <!-- Agregamos el token CSRF aquí -->
          <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Curso:</label>
            <input id="nombre" v-model="curso.nombre" type="text" required class="input-large" />
          </div>
          <div class="mb-4">
            <label for="duracion" class="block text-gray-700 text-sm font-bold mb-2">Duración en horas del curso:</label>
            <input id="duracion" v-model="curso.duracion" type="number" required class="input-large" />
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="btn-primary">Guardar</button>
            <button type="button" class="btn-secondary" @click="regresar">Regresar</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';

  const { csrfToken } = defineProps({
    csrfToken: String
});

// Función para limpiar los campos del formulario
const limpiarCampos = () => {
  curso.value.nombre = '';
  curso.value.duracion = '';
};

  const curso = ref({ nombre: '', duracion: '' });
  const submit = async () => {
    try {

      if (!csrfToken) {
        console.error('El token CSRF no está disponible en este momento.');
        return;
      }
  
      const response = await fetch('guardar-cursos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrfToken,
        },
        body: JSON.stringify(curso.value)
      });
  
      if (response.ok) {
        const data = await response.json();
        alert("Registor guardado con exito");
        limpiarCampos();
        router.get('ver-cursos');
      } else {
        console.error('Error en la solicitud:', response.statusText);
        alert("Error en la solicitud" , response.statusText);
      }
    } catch (error) {
      console.error('Error al enviar la solicitud:', error);
    }
  };
  
  const regresar = () => {
    // Implementa la lógica para regresar si es necesario
  };
  </script>
  
  <style scoped>
  .input-large {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    width: 100%;
  }
  
  .btn-primary {
    background-color: #4caf50;
    color: #fff;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 0.25rem;
    transition: background-color 0.3s;
  }
  
  .btn-primary:hover {
    background-color: #45a049;
  }
  
  .btn-secondary {
    background-color: #ccc;
    color: #333;
    border: none;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 0.25rem;
    transition: background-color 0.3s;
  }
  
  .btn-secondary:hover {
    background-color: #b3b3b3;
  }
  </style>
  