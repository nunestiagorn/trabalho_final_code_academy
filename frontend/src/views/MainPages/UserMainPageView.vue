<template>
  <main class="bg-primaryColor h-screen flex justify-between">
    <section class=""></section>
    <aside class="bg-neutral-200 flex w-72 justify-center px-2 py-4">
      <div class="flex flex-col">
        <div class="flex gap-4 items-center">
          <img
            src="../../assets/images/user.png"
            alt="foto do usuário"
            class="size-14"
          />
          <div class="flex flex-col">
            <h2 class="text-black">Usuário</h2>
            <h3 class="text-zinc-600">usuario@gmail.com</h3>
          </div>
        </div>
      </div>
      <div></div>
    </aside>
  </main>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      users: {
        id: "",
        name: "",
        email: "",
        role: "",
      },
    };
  },
  methods: {
    LoggedUser() {
      axios
        .post(`http://localhost:8001/api/users`, this.users)
        .then(({ data }) => {});
    },
  },
};
</script>
