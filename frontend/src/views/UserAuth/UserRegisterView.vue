<template>
  <main class="flex w-full">
    <section
      class="h-screen bg-secondaryColor w-full bg-register-cover flex items-center justify-center"
    >
      <img
        src="../../assets/images/register.jpg"
        alt="Foto de entrevista na página de login"
        class="w-[36rem] h-[28rem] rounded-2xl shadow-shadow1 bg-contain bg-center"
      />
    </section>

    <section
      class="h-screen text-slate-950 flex flex-col gap-6 w-4/6 px-10 py-5"
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
          Encontre aqui as melhores oportunidades para a sua carreira!
        </h4>
      </div>

      <div class="flex items-center justify-center">
        <form @submit.prevent="registerUser" class="w-9/12 flex flex-col gap-8">
          <div class="flex items-center border-b-2 border-black">
            <UserPlus class="ml-2" />
            <input
              v-model="users.name"
              type="text"
              class="input1"
              placeholder="Insira seu nome"
            />
          </div>

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
              <p>Já possui uma conta?</p>
              <div class="flex gap-1 group">
                <RouterLink
                  to="/login"
                  class="underline underline-offset-4 hover:text-secondaryColor"
                >
                  <p>Entre agora mesmo!</p>
                </RouterLink>
                <ArrowRight
                  class="size-5 self-center group-hover:translate-x-2 transition-all duration-150"
                />
              </div>
              <div class="flex gap-1 group">
                <RouterLink
                  to="/company-login"
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
              Criar
            </button>
          </div>
        </form>
      </div>

      <div class="flex font-bold text-lg absolute bottom-6 right-6">
        <RouterLink
          to="/"
          class="pl-3 pr-4 py-2.5 hover:text-zinc-300 bg-lightBlue rounded-[100px] hover:bg-primaryColor transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl"
        >
          <ArrowLeft />
          Home
        </RouterLink>
      </div>
    </section>

    <Modal
      :visivel="Visivel"
      @close="Visivel = false"
      @confirm="redirecionarLogin"
      :status="modalStatus"
      :headerClass="
        modalStatus === 'error' ? 'bg-red-500' : 'bg-secondaryColor'
      "
    >
      <template #header>
        {{ modalStatus === "success" ? "Sucesso" : "Falha" }}
      </template>
      <template #body>
        <p>
          {{
            modalStatus === "success"
              ? "Sua conta foi criada com sucesso!!!"
              : "Falha ao acessar a conta. Verifique as credenciais e tente novamente."
          }}
        </p>
        <img
          :src="modalStatus === 'success' ? successIcon : errorIcon"
          alt="icon"
          :class="[
            modalStatus === 'success'
              ? 'absolute size-80 top-52 left-60 -rotate-[24deg]'
              : 'absolute size-80 top-24 right-36',
          ]"
        />

        <img
          v-if="modalStatus === 'error'"
          src="../../assets/images/error.png"
          alt="icon"
          class="absolute size-80 bottom-16 left-36 -scale-x-100"
        />
      </template>
    </Modal>
  </main>
</template>

<script>
import {
  ArrowLeft,
  ArrowRight,
  LockKeyhole,
  Mail,
  UserPlus,
} from "lucide-vue-next";
import successIcon from "@/assets/images/caderno.png";
import errorIcon from "@/assets/images/error.png";

import axios from "axios";
import Modal from "@/components/Modals/Modal.vue";

import "vue3-toastify/dist/index.css";
import { toast } from "vue3-toastify";

const Toast = (mensagem, type) => {
  toast(mensagem, {
    type: type,
    autoClose: 2500,
    multiple: false,
    position: "top-center",
    toastStyle: {
      fontSize: "22px",
    },
  });
};

export default {
  name: "UserRegister",
  components: {
    ArrowLeft,
    ArrowRight,
    LockKeyhole,
    Mail,
    UserPlus,
    Modal,
  },
  data() {
    return {
      users: {
        name: "",
        email: "",
        password: "",
        role: "candidate",
      },
      Visivel: false,
      modalStatus: "",
      successIcon,
      errorIcon,
    };
  },
  methods: {
    registerUser() {
      if (!this.users.name.trim()) {
        Toast("O campo Nome deve ser preenchido.", "error");
        return;
      }
      if (!this.users.email.trim()) {
        Toast("O campo Email deve ser preenchido.", "error");
        return;
      }
      if (!this.users.password.trim()) {
        Toast("O campo Senha deve ser preenchido.", "error");
        return;
      }
      if (this.users.password.length < 6) {
        Toast("A senha deve ter no mínimo 6 caracteres.", "error");
        return;
      }

      axios
        .post(`http://localhost:8001/api/users`, this.users)
        .then(({ data }) => {
          try {
            this.modalStatus = data.status ? "success" : "error";
            this.Visivel = true;
          } catch (err) {
            alert("Falha no sistema");
          }
        })
        .catch((error) => {
          if (error.response && error.response.status === 400) {
            Toast("Este e-mail já está cadastrado no sistema.", "error");
          }
        });
    },
    redirecionarLogin() {
      this.Visivel = false;

      if (this.modalStatus === "success") {
        this.$router.push({ name: "login" });
      }
    },
  },
};
</script>
