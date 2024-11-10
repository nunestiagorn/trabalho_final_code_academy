<template>
  <main class="bg-recruiter">
    <div class="bg-black/35 h-screen w-screen flex items-center justify-center">
      <div
        class="bg-darkerBlue p-12 w-5/12 items-center justify-center flex flex-col gap-8 border-4 border-black rounded-xl shadow-shadow2"
      >
        <div class="flex gap-2 items-center">
          <img
            src="../../assets/images/logo.png"
            alt="Logo do site"
            class="size-14"
          />
          <h2 class="text-2xl font-semibold italic">
            Insira os dados de sua empresa
          </h2>
        </div>

        <form
          @submit.prevent="loginCompany"
          class="w-full flex justify-evenly items-center gap-2"
        >
          <div class="flex flex-col gap-8 w-5/6">
            <div class="flex items-center border-b-2 border-black">
              <Building2 class="ml-2" />
              <input
                v-model="companies.cnpj"
                type="text"
                class="input2"
                placeholder="Insira o CNPJ"
                @input="formatCNPJ"
              />
            </div>

            <div class="flex items-center border-b-2 border-black">
              <LockKeyhole class="ml-2" />
              <input
                v-model="companies.password"
                type="password"
                class="input2"
                placeholder="Sua Senha"
              />
            </div>
          </div>

          <button
            type="submit"
            class="p-4 bg-darkBlue rounded-full ml-9 group shadow-shadow3"
          >
            <ArrowRight
              class="size-6 group-hover:translate-x-1.5 transition-all"
            />
          </button>
        </form>

        <div class="flex flex-col self-start ml-2">
          <h2>Não possui empresa cadastrada?</h2>
          <div class="group flex gap-1">
            <RouterLink
              to="/company-register"
              class="underline underline-offset-4 hover:text-secondaryColor"
            >
              <p>Cadastre Já!</p>
            </RouterLink>
            <ArrowRight
              class="size-5 self-center group-hover:translate-x-2 transition-all duration-150"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="flex font-bold text-xl absolute bottom-6 left-6">
      <RouterLink
        to="/"
        class="pl-3 pr-4 py-3 hover:text-zinc-300 bg-secondaryColor rounded-[100px] hover:bg-primaryColor transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl"
      >
        <ArrowLeft />
        Home
      </RouterLink>
    </div>

    <Modal
      :visivel="Visivel"
      @close="Visivel = false"
      @confirm="redirecionarLogin"
    >
      <template #header>
        <p class="text-black">Sucesso!!!</p>
      </template>
      <template #body>
        <p>Seja bem-vindo(a) ao Pampa's RH!!!</p>
        <img
          src="../../assets/images/caderno.png"
          alt="megafoce icon"
          class="absolute size-80 top-52 left-60 -rotate-[24deg]"
        />
      </template>
    </Modal>
    
  </main>
</template>

<script>
import { ref } from "vue";
import { Building2, LockKeyhole, ArrowRight, ArrowLeft } from "lucide-vue-next";
import Modal from "@/components/Modals/Modal.vue";

import axios from "axios";

export default {
  components: {
    Building2,
    LockKeyhole,
    ArrowRight,
    ArrowLeft,
    Modal,
  },
  data() {
    return {
      companies: {
        cnpj: "",
        password: "",
      },
      csrf: document.head.querySelector('meta[name="csrf-token"]')
        ? document.head.querySelector('meta[name="csrf-token"]').content
        : "",
      companyId: "",
      Visivel: false,
    };
  },
  methods: {
    formatCNPJ() {
      let value = this.companies.cnpj.replace(/\D/g, "");
      value = value.slice(0, 14);

      if (value.length <= 14) {
        value = value.replace(/^(\d{2})(\d)/, "$1.$2");
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
        value = value.replace(/\.(\d{3})(\d)/, ".$1/$2");
        value = value.replace(/(\d{4})(\d)/, "$1-$2");
      }

      this.companies.cnpj = value;
    },
    loginCompany() {
      axios
        .post(`http://localhost:8001/api/companies/login`, this.companies)
        .then(({ data }) => {
          try {
            console.log(data);
            if (data.status === true) {
              this.companyId = data.company.id;
              localStorage.setItem("companyId", this.companyId);
              this.Visivel = true;
            } else {
              alert("Falha ao entrar na sua conta");
            }
          } catch (err) {
            alert("Falha no sistema");
            console.log(err);
          }
        });
    },
    redirecionarLogin() {
      this.Visivel = false;

      this.$router.push({
        name: "company-mainpage",
        params: { id: this.companyId },
      });
    },
  },
};
</script>
