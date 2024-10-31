<template>
  <main class="h-screen flex justify-between bg-cover-main">
    <section class=""></section>

    <aside class="bg-neutral-200 flex flex-col w-72 items-center gap-8 p-4">
      <div class="flex flex-col py-5">
        <div class="flex gap-4 items-center">
          <img
            src="../../assets/images/user.png"
            alt="foto do usuário"
            class="size-14 rounded-full"
          />
          <div class="flex flex-col">
            <h2 class="text-black text-xl font-bold">{{ users.name }}</h2>
            <h3 class="text-zinc-600 text-md -mt-1">{{ users.email }}</h3>
          </div>
        </div>
      </div>
      <section
        class="flex flex-col justify-between h-full w-full px-4 font-semibold text-zinc-200 text-lg"
      >
        <div class="flex flex-col gap-5">
          <div class="sidebar_item">
            <UserCog />
            Editar Perfil
          </div>
          <div class="sidebar_item">
            <ChevronLeft />
            teste
          </div>
          <div class="sidebar_item">
            <ChevronLeft />
            teste
          </div>
          <div class="sidebar_item">
            <ChevronLeft />
            teste
          </div>
        </div>
        <div class="sidebar_item_exit">
          <LogOut />
          Sair
        </div>
      </section>
    </aside>
  </main>
</template>

<script>
import { ChevronLeft, LogOut, UserCog } from "lucide-vue-next";
import axios from "axios";

export default {
  components: {
    ChevronLeft,
    LogOut,
    UserCog,
  },
  data() {
    return {
      users: {
        name: '',
        email: ''
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
          this.users.name = data.name;
          this.users.email = data.email;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
