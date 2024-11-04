<template>
  <aside class="bg-neutral-200 flex flex-col w-3/12 items-center gap-6 p-3">
    <div class="flex flex-col pt-4">
      <div class="flex gap-4 items-center">
        <img
          src="@/assets/images/user.png"
          alt="foto do usuário"
          class="size-14 rounded-full"
        />
        <div class="flex flex-col">
          <h2 class="text-black text-xl font-bold capitalize">
            {{ user.name }}
          </h2>
          <h3 class="text-zinc-600 text-md -mt-1">{{ user.email }}</h3>
        </div>
      </div>
    </div>

    <hr class="border-px border-zinc-500 w-11/12" />

    <section
      class="flex flex-col justify-between h-full w-full px-4 font-semibold text-zinc-200 text-lg"
    >
      <div class="flex flex-col gap-5">
        <RouterLink to="/editar_perfil" class="sidebar_item">
          <UserCog />
          Editar Perfil
        </RouterLink>
        <RouterLink to="/123" class="sidebar_item">
          <FileText />
          Currículo
        </RouterLink>
        <RouterLink to="/user-vagas" class="sidebar_item">
          <Handshake />
          Procurar Vagas
        </RouterLink>
        <RouterLink to="/123" class="sidebar_item">
          <Building2 />
          Empresas
        </RouterLink>
        <RouterLink to="/123" class="sidebar_item">
          <Info />
          Ajuda
        </RouterLink>
      </div>

      <div class="flex gap-2">
        <RouterLink @click="Sair()" to="/" class="sidebar_item_exit">
          <LogOut />
          Sair
        </RouterLink>
        <RouterLink to="/bug_report" class="sidebar_item_exit">
          <Bug />
          Bug
        </RouterLink>
      </div>
    </section>
  </aside>
</template>

<script>
import {
  Bug,
  ChevronLeft,
  FileText,
  Handshake,
  Info,
  LogOut,
  UserCog,
  Building2,
} from "lucide-vue-next";

import axios from "axios";
import { RouterLink } from "vue-router";

export default {
  components: {
    ChevronLeft,
    LogOut,
    UserCog,
    Bug,
    FileText,
    Handshake,
    Info,
    Building2,
  },
  data() {
    return {
      user: {
        name: "",
        email: "",
      },
    };
  },
  mounted() {
    this.LoggedUser();
  },
  methods: {
    LoggedUser() {
      const userId = this.$route.params.id;
      axios
        .get(`http://localhost:8001/api/users/${userId}`)
        .then(({ data }) => {
          this.user.name = data.name;
          this.user.email = data.email;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    Sair() {
      const userId = this.$route.params.id;

      localStorage.removeItem("userId");
    },
  },
};
</script>
