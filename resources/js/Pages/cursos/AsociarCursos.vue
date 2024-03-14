<template>
    <div class="flex flex-col items-center justify-center h-screen">
      <h2 class="text-2xl mb-4">Asociar Usuarios a Cursos</h2>
      <div class="w-72 mb-4">
        <label for="selectUser" class="block mb-1">Seleccionar Usuario:</label>
        <select id="selectUser" v-model="selectedUser" class="w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          <option disabled value="">Seleccionar Usuario</option>
          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>
      </div>
      <div class="w-72 mb-4">
        <label for="selectCourse" class="block mb-1">Seleccionar Curso:</label>
        <select id="selectCourse" v-model="selectedCourse" class="w-full rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          <option disabled value="">Seleccionar Curso</option>
          <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
        </select>
      </div>
      <button @click="associateUserToCourse" class="btn-primary mb-4">Asociar Usuario a Curso</button>
  
      <!-- Tabla para mostrar la asociación de usuarios a cursos -->
      <div class="w-96">
        <h3 class="text-xl mb-4">Usuarios asociados a Cursos</h3>
        <table class="border-collapse border border-gray-300 w-full mb-4">
          <thead>
            <tr>
              <th class="border border-gray-300 px-4 py-2">Curso</th>
              <th class="border border-gray-300 px-4 py-2">Usuario</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(userCourse, index) in userCourses" :key="index">
              <td class="border border-gray-300 px-4 py-2">{{ userCourse.course }}</td>
              <td class="border border-gray-300 px-4 py-2">{{ userCourse.user }}</td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Botones de guardar y regresar -->
      <div class="flex justify-center">
        <button @click="guardarAsociaciones" class="btn-primary mr-4">Guardar</button>
        <button @click="regresar" class="btn-secondary">Atrás</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  

  const { csrfToken, users: initialUsers, courses: initialCourses } = defineProps({
  csrfToken: String,
  users: Array,
  courses: Array
});

// Variables reactivas para almacenar los datos de usuarios, cursos y selecciones
const users = ref(initialUsers);
const courses = ref(initialCourses);
const selectedUser = ref(null);
const selectedCourse = ref(null);
const userCourses = ref([]);
  
  // Función para asociar usuario a curso
  const associateUserToCourse = () => {
    if (selectedUser.value && selectedCourse.value) {
      // Lógica para asociar usuario a curso (puedes implementarla según tu lógica específica)
      userCourses.value.push({ course: `Curso ${selectedCourse.value}`, user: `Usuario ${selectedUser.value}` });
      
      // Limpiar la selección después de asociar usuario a curso
      selectedUser.value = null;
      selectedCourse.value = null;
    } else {
      alert('Por favor selecciona un usuario y un curso.');
    }
  };
  
  const guardarAsociaciones = async () => {
    try {
        if (!csrfToken) {
            console.error('El token CSRF no está disponible en este momento.');
            return;
        }

        const response = await fetch('guardar-asociados', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken,
            },
            body: JSON.stringify({
                user_id: selectedUser.value,
                course_id: selectedCourse.value,
            }),
        });

        if (response.ok) {
            alert('Asociaciones guardadas correctamente.');
            // Limpiar los valores después de guardar
            selectedUser.value = null;
            selectedCourse.value = null;
        } else {
            console.error('Error al guardar la asociación:', response.statusText);
            alert('Error al guardar la asociación.');
        }
    } catch (error) {
        console.error('Error al enviar la solicitud:', error);
        alert('Error al enviar la solicitud.');
    }
};

  
  // Función para regresar a la página anterior
  const regresar = () => {
    router.get('dasboard');
  };
  </script>
  
  <style scoped>
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
  