<template>
  <main class="flex w-full">
    <section
      class="h-screen text-slate-950 flex flex-col gap-7 w-4/6 px-10 py-5"
    >
      <div class="flex gap-4 items-center">
        <img
          src="../../assets/images/logo.png"
          alt="Logo da página"
          class="w-20 invert"
        />
        <h1 class="text-5xl font-bold italic">Pampa's RH</h1>
      </div>
      <div class="italic font-medium">
        <h3 class="text-2xl font-bold">Bem-vindo ao Pampa's RH Enterprises</h3>
        <h4 class="text-lg">
          Acesse a sua conta para gerenciar suas candidaturas e oportunidades.
        </h4>
      </div>

      <div class="flex items-center justify-center">
        <form @submit.prevent="LoginUser" class="w-9/12 flex flex-col gap-10">
          <div class="flex items-center border-b-2 border-black">
            <Mail class="ml-2" />
            <input
              v-model="users.email"
              type="email"
              class="input1"
              placeholder="Insira seu email"
            />
          </div>

          <div class="flex items-center border-b-2 border-black">
            <LockKeyhole class="ml-2" />
            <input
              v-model="users.password"
              type="password"
              class="input1"
              placeholder="Insira sua senha"
            />
          </div>

          <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1">
              <p>Não tem uma conta ainda?</p>
              <div class="flex gap-1 group">
                <RouterLink
                  to="/register"
                  class="underline underline-offset-4 hover:text-secondaryColor"
                >
                  <p>Crie agora mesmo!</p>
                </RouterLink>
                <ArrowRight
                  class="size-5 self-center group-hover:translate-x-2 transition-all duration-150"
                />
              </div>
              <div class="flex gap-1 group">
                <RouterLink
                  to="/recruiter-login"
                  class="underline underline-offset-4 hover:text-secondaryColor"
                >
                  <p>É um recrutador? Entre aqui!</p>
                </RouterLink>
                <ArrowRight
                  class="size-5 self-center group-hover:translate-x-2 transition-all duration-150"
                />
              </div>
            </div>
            <button
              type="submit"
              class="px-5 py-2.5 hover:text-zinc-300 bg-lightBlue rounded-[100px] hover:bg-primaryColor transition-all items-center shadow-xl font-bold hover:rounded-xl"
            >
              Entrar
            </button>
          </div>
        </form>
      </div>

      <div class="flex font-bold text-lg absolute bottom-6 left-6">
        <RouterLink
          to="/"
          class="pl-3 pr-4 py-2.5 hover:text-zinc-300 bg-lightBlue rounded-[100px] hover:bg-primaryColor transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl"
        >
          <ArrowLeft />
          Home
        </RouterLink>
      </div>
    </section>

    <section
      class="h-screen bg-secondaryColor w-full bg-login-cover flex items-center justify-center"
    >
      <img
        src="../../assets/images/Interview1.jpg"
        alt="Foto de entrevista na página de login"
        class="w-[36rem] h-[28rem] rounded-2xl shadow-shadow1 bg-contain bg-center"
      />
    </section>
  </main>
</template>

<script>
import { ArrowLeft, ArrowRight, LockKeyhole, Mail } from "lucide-vue-next";

import axios from "axios";

export default {
  name: "Login",
  components: {
    ArrowLeft,
    ArrowRight,
    LockKeyhole,
    Mail,
  },
  data() {
    return {
      users: {
        id: "",
        name: "",
        email: "",
        role: "",
        password: "",
        id_companies: "",
      },
    };
  },
  methods: {
    LoginUser() {
      axios
        .post(`http://localhost:8001/api/users/login`, this.users)
        .then(({ data }) => {
          console.log(data);
          try {
            if (data.status === true) {
              alert("Login realizado com sucesso!");
              this.$router.push({ name: "Home" });
            } else {
              alert("Falha ao entrar na sua conta");
            }
          } catch (err) {
            alert("Falha no sistema");
          }
        });
    },
  },
};
</script>
