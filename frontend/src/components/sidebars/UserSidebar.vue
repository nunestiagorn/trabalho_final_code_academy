<template>
  <aside class="bg-neutral-200 flex flex-col w-3/12 items-center gap-6 p-3">
    <div class="flex flex-col pt-4">
      <div class="flex gap-4 items-center">
        <img
          :src="
            user.image
              ? `http://localhost:8001/api/users/${userId}/image`
              : '@/assets/images/user.png'
          "
          alt="foto do usuário"
          class="w-14 h-14 rounded-full"
          @error="handleImageError"
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
        <button @click.prevent="abrirModal()" class="user_sidebar_item">
          <UserCog />
          Editar Perfil
        </button>
        <button @click.prevent="abrirModalCurriculum()" class="user_sidebar_item">
          <FileText />
          Currículo
        </button>
        <RouterLink
          :to="`/${userId}/vacancies`"
          class="bg-green-600 py-2.5 px-3 w-full flex items-center gap-1.5 rounded-lg cursor-pointer hover:translate-x-2 transition-all hover:bg-emerald-700 hover:font-bold shadow-lg"
        >
          <Handshake />
          Procurar Vagas
        </RouterLink>
        <RouterLink to="/company-list" class="user_sidebar_item">
          <Building2 />
          Empresas
        </RouterLink>
        <RouterLink to="/123" class="user_sidebar_item">
          <Info />
          Ajuda
        </RouterLink>
      </div>

      <div class="flex gap-2">
        <button @click="Sair" class="sidebar_item_exit">
          <LogOut />
          Sair
        </button>
        <RouterLink to="/bug_report" class="sidebar_item_exit">
          <Bug />
          Bug
        </RouterLink>
      </div>
    </section>

    <ModalUser :visivel="VisivelUser" @close="VisivelUser = false">
      <template #headerUser>
        Editar seus dados: {{ user.name }}
      </template>
      <template #bodyUser>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-4">
            <p class="text-2xl font-bold">Altere o seu nome:</p>
            <input
              v-model="user.name"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Editar nome..."
              maxlength="25"
            />
            <p class="text-2xl font-bold">Altere o sua foto de perfil:</p>
            <input
              type="file"
              @change="onFileChange"
              class="p-2 rounded-lg outline-none shadow-lg"
              accept="image/*"
            />
          </div>

          <button
            @click="saveUser"
            type="submit"
            class="bg-secondaryColor active:scale-75 shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
          >
            Salvar
          </button>
        </div>
      </template>
    </ModalUser>

    <ModalCurriculum :visivel="VisivelCurriculum" @close="VisivelCurriculum = false">
      <template #headerCurriculum>
        Envie seu currículo
      </template>
      <template #bodyCurriculum>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-4">
            <p class="text-2xl font-bold">Dê upload de seu currículo em PDF:</p>
            <input
              type="file"
              @change="onFileChangeCurriculum"
              class="p-2 rounded-lg outline-none shadow-lg"
              accept="application/pdf"
            />
          </div>

          <button
            @click="saveUser"
            type="submit"
            class="bg-secondaryColor active:scale-75 shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
          >
            Salvar
          </button>
        </div>
      </template>
    </ModalCurriculum>
  </aside>
</template>

<script>
import {
  Bug,
  FileText,
  Handshake,
  Info,
  LogOut,
  UserCog,
  Building2,
} from "lucide-vue-next";
import ModalUser from "../Modals/UserModal.vue";
import ModalCurriculum from "../Modals/CurriculumModal.vue";

import axios from "axios";
import { RouterLink } from "vue-router";
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
  components: {
    LogOut,
    UserCog,
    Bug,
    FileText,
    Handshake,
    Info,
    Building2,
    ModalUser,
    ModalCurriculum,
  },
  data() {
    return {
      user: {
        name: "",
        email: "",
        image: "",
      },
      VisivelUser: false,
      VisivelCurriculum: false,
    };
  },
  mounted() {
    this.LoggedUser();
  },
  computed: {
    userId() {
      return localStorage.getItem("userId");
    },
  },
  methods: {
    handleImageError(event) {
      event.target.src = "/src/assets/images/user.png";
    },
    LoggedUser() {
      const userId = this.$route.params.id;
      axios
        .get(`http://localhost:8001/api/users/${userId}`)
        .then(({ data }) => {
          this.user.name = data.name;
          this.user.email = data.email;
          if (data.image) {
            this.user.image = `http://localhost:8001/api/users/${userId}/image`;
          }
        })
        .catch((error) => {
          console.error("Erro ao buscar usuário:", error);
        });
    },
    abrirModal() {
      this.VisivelUser = true;
    },
    abrirModalCurriculum() {
      this.VisivelCurriculum = true;
    },
    onFileChangeCurriculum(event) {
      const file = event.target.files[0];
      if (file && file.type === "application/pdf") {
        const formData = new FormData();
        formData.append("curriculum", file);

        const userId = this.$route.params.id;
        axios
          .post(`http://localhost:8001/api/users/${userId}/curriculum`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then(() => {
            Toast("Currículo enviado com sucesso!", "success");
          })
          .catch((error) => {
            console.error("Erro ao enviar currículo:", error);
            Toast("Falha ao enviar currículo :(", "error");
          });
      } else {
        Toast("Por favor, envie apenas um arquivo PDF.", "error");
      }
    },
    onFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        const formData = new FormData();
        formData.append("image", file);

        const userId = this.$route.params.id;
        axios
          .post(`http://localhost:8001/api/users/${userId}/image`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .catch((error) => {
            console.error("Erro ao atualizar a imagem:", error);
            Toast("Falha ao atualizar a imagem :(", "error");
          });
      }
    },
    saveUser() {
      const userId = this.$route.params.id;
      axios
        .put(`http://localhost:8001/api/users/${userId}`, {
          name: this.user.name,
        })
        .then(() => {
          Toast("Usuário atualizado!", "success");
        })
        .catch((error) => {
          console.error("Erro ao atualizar usuário:", error);
        });
    },
    Sair() {
      localStorage.removeItem("userId");
      this.$router.push("/");
    },
  },
};
</script>
