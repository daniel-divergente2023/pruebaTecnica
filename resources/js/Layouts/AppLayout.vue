<template>
  <div>
    <Head :title="title" />

    <Banner />

    <div class="min-h-screen bg-gray-100">
      
      <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                  <ApplicationMark class="block h-9 w-auto" />
                </Link>
              </div>

           
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                  Dashboard
                </NavLink>
                <!-- Mostrar opciones según el rol -->
                <template v-if="user && user.role === 'admin'">
                  <NavLink :href="route('ver.usuarios')" :active="route().current('ver.usuarios')">
                    Crear Usuarios
                  </NavLink>
                  <NavLink :href="route('ver.cursos')" :active="route().current('ver.cursos')">
                    Crear Cursos
                  </NavLink>
                    <!-- Menú adicional para asociar cursos -->
                    <NavLink :href="route('ver.cursosa')" :active="route().current('ver.cursosa')">
                        Asociar Cursos
                    </NavLink>
                </template>
                <template v-else>
                  <NavLink :href="route('ver.cursos')" :active="route().current('ver.cursos')">
                    Ver Cursos
                  </NavLink>
                </template>
              </div>
            </div>

              <!-- Authentication -->
              <form @submit.prevent="logout">
                  <DropdownLink as="button">
                      Log Out
                  </DropdownLink>
              </form>
          </div>
        </div>

        <!-- Resto del código... -->
      </nav>

     <!-- Mensaje de bienvenida -->
     <div class="flex justify-center items-center h-screen bg-gray-100">
           <span v-if="user && user.role === 'admin'" class="text-4xl text-blue-500">Bienvenido administrador</span>
          <span v-else-if="user && user.role === 'student'" class="text-4xl text-green-500">Bienvenido estudiante</span>
      </div>

    </div>
  </div>
</template>


<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
title: String,
user: Object
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
  router.put(route('current-team.update'), {
      team_id: team.id,
  }, {
      preserveState: false,
  });
};

const logout = () => {
  router.post(route('logout'));
};
</script>
