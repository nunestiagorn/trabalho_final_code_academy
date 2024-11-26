<template>
  <aside class="bg-neutral-200 flex flex-col w-3/12 items-center gap-3 p-2">
    <div class="flex flex-col pt-4">
      <div class="flex flex-col gap-3 items-center">
        <h3 class="text-zinc-600 text-md -mt-1">CNPJ: {{ company.cnpj }}</h3>
        <img
          src="@/assets/images/company.png"
          alt="foto da empresa"
          class="size-16 rounded-full"
        />
        <div
          class="-mt-1.5 flex flex-col text-black capitalize items-center gap-1"
        >
          <h2
            class="font-bold text-xl underline underline-offset-4 text-center"
          >
            {{ company.name }}
          </h2>

          <div
            class="flex flex-col gap-0.5 text-center mt-1.5 text-lg bg-white px-2.5 py-1 rounded-lg shadow-lg font-medium"
          >
            <p>Recrutador:</p>
            <p class="underline underline-offset-4 text-neutral-700">
              {{ company.recruiter_name }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <hr class="border-px border-zinc-500 w-11/12" />

    <section
      class="flex flex-col justify-between h-full w-full px-4 font-semibold text-zinc-200 text-lg"
    >
      <div class="flex flex-col gap-3">
        <button
          @click.prevent="abrirModalRecruiter()"
          class="company_sidebar_item"
        >
          <UserCog class="ml-0.5" />
          <p class="-ml-1">Editar Recrutador</p>
        </button>

        <button
          @click.prevent="abrirModalCompany()"
          class="company_sidebar_item"
        >
          <MonitorCog />
          Editar Empresa
        </button>

        <button
          @click.prevent="abrirModalJob()"
          class="py-2.5 px-3 w-full flex items-center gap-2.5 rounded-lg cursor-pointer hover:-translate-x-2 transition-all hover:bg-emerald-700 hover:font-bold shadow-lg bg-green-600"
        >
          <Grid2x2Plus />
          Publicar Vaga
        </button>

        <RouterLink to="/help" class="company_sidebar_item">
          <Info />
          Ajuda
        </RouterLink>
      </div>

      <div class="flex gap-2">
        <RouterLink to="/bug_report" class="sidebar_item_exit">
          <Bug />
          Bug
        </RouterLink>
        <RouterLink @click="Sair()" to="/" class="sidebar_item_exit">
          <LogOut />
          Sair
        </RouterLink>
      </div>
    </section>

    <ModalRecruiter
      :visivel="VisivelRecruiter"
      @close="VisivelRecruiter = false"
    >
      <template #headerRecruiter>
        Editar o Recrutador da empresa: {{ company.name }}
      </template>
      <template #bodyRecruiter>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-4">
            <p class="text-2xl font-bold">Altere o Recrutador:</p>
            <input
              v-model="company.recruiter_name"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Editar Recrutador..."
              minlength="3"
              maxlength="25"
            />
          </div>

          <button
            @click="editRecruiter"
            type="submit"
            class="bg-secondaryColor active:scale-75 shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
          >
            Salvar
          </button>
        </div>
      </template>
    </ModalRecruiter>

    <ModalCompany :visivel="VisivelCompany" @close="VisivelCompany = false">
      <template #headerCompany> Editar a empresa: {{ company.name }} </template>
      <template #bodyCompany>
        <div class="flex flex-col gap-3">
          <div class="flex flex-col gap-3">
            <p class="text-2xl font-bold">Altere o nome da Empresa:</p>
            <input
              v-model="company.name"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Editar o nome da Empresa..."
              maxlength="35"
            />
            <p class="text-2xl font-bold">Altere a descrição da Empresa:</p>
            <input
              v-model="company.description"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Editar a descrição da Empresa..."
              maxlength="100"
            />
            <p class="text-2xl font-bold">Altere a foto de perfil da Empresa:</p>
            <input

            />
          </div>

          <button
            @click="saveCompany"
            type="submit"
            class="bg-secondaryColor active:scale-75 shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-darkBlue transition-all"
          >
            Salvar
          </button>
        </div>
      </template>
    </ModalCompany>

    <ModalJob :visivel="VisivelJob" @close="VisivelJob = false">
      <template #headerJob> Publicando vaga...</template>
      <template #bodyJob>
        <div class="flex flex-col gap-4">
          <div class="flex flex-col gap-4">
            <p class="text-2xl font-bold">Insira o título da Vaga</p>
            <input
              v-model="job.name"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Vaga..."
              maxlength="35"
            />
            <input
              v-model="job.salary"
              @input="formatSalary"
              class="p-2 rounded-lg outline-none shadow-lg"
              placeholder="Salário... (ex.: 1.500,00)"
              maxlength="14"
            />
            <p class="text-2xl font-bold">Insira a descrição da vaga:</p>
            <textarea
              v-model="job.description"
              class="p-2 rounded-lg outline-none shadow-lg min-h-40 resize-none"
              placeholder="Descrição da vaga..."
              maxlength="300"
            />
          </div>

          <button
            @click="saveJob"
            type="submit"
            class="bg-green-600 active:scale-75 shadow-lg self-end py-1 px-3 rounded-lg text-zinc-200 font-semibold hover:bg-emerald-700 transition-all"
          >
            Publicar
          </button>
        </div>
      </template>
    </ModalJob>
  </aside>
</template>

<script>
import {
  Bug,
  LogOut,
  UserCog,
  Grid2x2Plus,
  Info,
  MonitorCog,
} from "lucide-vue-next";

import axios from "axios";
import { RouterLink } from "vue-router";
import ModalRecruiter from "@/components/Modals/RecruiterModal.vue";
import ModalCompany from "@/components/Modals/CompanyModal.vue";
import ModalJob from "@/components/Modals/JobModal.vue";
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
    Bug,
    LogOut,
    UserCog,
    Grid2x2Plus,
    Info,
    MonitorCog,
    ModalRecruiter,
    ModalCompany,
    ModalJob,
  },
  data() {
    return {
      company: {
        id: "",
        name: "",
        cnpj: "",
        description: "",
        recruiter_name: "",
      },
      job: {
        id: "",
        name: "",
        description: "",
        salary: "",
        company_id: "",
        recruiter_name: "",
      },
      VisivelRecruiter: false,
      VisivelCompany: false,
      VisivelJob: false,
    };
  },
  mounted() {
    this.LoggedCompany();
  },
  methods: {
    LoggedCompany() {
      const companyId = this.$route.params.id;

      axios
        .get(`http://localhost:8001/api/companies/${companyId}`)
        .then(({ data }) => {
          this.company = {
            id: data.id,
            cnpj: data.cnpj,
            name: data.name,
            recruiter_name: data.recruiter_name,
            description: data.description,
          };
        })
        .catch((error) => {
          console.log(error);
        });
    },
    Sair() {
      localStorage.removeItem("companyId");
    },
    abrirModalRecruiter() {
      this.VisivelRecruiter = true;
    },
    abrirModalCompany() {
      this.VisivelCompany = true;
    },
    abrirModalJob() {
      this.VisivelJob = true;
      this.job = {
        id: "",
        name: "",
        description: "",
        salary: "",
        company_id: this.company.id,
        recruiter_name: this.company.recruiter_name,
      };
    },
    editRecruiter() {
      if (!this.company.recruiter_name.trim()) {
        Toast("Erro: O nome do recrutador não pode estar vazio.", "error");
        return;
      }

      if (this.company.recruiter_name.length < 3) {
        Toast(
          "Erro: O nome do recrutador deve ter pelo menos 3 caracteres.",
          "error"
        );
        return;
      }

      axios
        .put(`http://localhost:8001/api/companies/${this.company.id}`, {
          recruiter_name: this.company.recruiter_name,
        })
        .then(() => {
          Toast("Recrutador Atualizado!", "success");
        })
        .catch((error) => {
          console.error("Erro ao atualizar recrutador:", error);
          Toast("Erro ao atualizar Recrutador :(", "error");
        });
    },
    saveCompany() {
      if (!this.company.name.trim()) {
        Toast("O nome da empresa não pode estar vazio.", "error");
        return;
      }

      if (this.company.name.length < 6) {
        Toast("O nome da empresa deve ter pelo menos 6 caracteres.", "error");
        return;
      }

      if (!this.company.description.trim()) {
        Toast("A descrição da empresa não pode estar vazia.", "error");
        return;
      }

      if (this.company.description.length < 20) {
        Toast(
          "A descrição da empresa deve ter pelo menos 20 caracteres.",
          "error"
        );
        return;
      }

      axios
        .put(`http://localhost:8001/api/companies/${this.company.id}`, {
          name: this.company.name,
          description: this.company.description,
        })
        .then(() => {
          Toast("Empresa Atualizada!", "success");
        })
        .catch((error) => {
          console.error("Erro ao atualizar a empresa:", error);
          Toast("Erro ao atualizar dados da empresa :(", "error");
        });
    },
    saveJob() {
      axios
        .post(`http://localhost:8001/api/job_openings/`, {
          name: this.job.name,
          description: this.job.description,
          salary: this.job.salary,
          company_id: this.company.id,
          recruiter_name: this.company.recruiter_name,
        })
        .then(() => {
          Toast("Vaga publicada!", "success");
        })
        .catch((error) => {
          console.error("Erro ao criar vaga:", error);
          Toast("Erro ao publicar vaga :(", "error");
        });
    },
    formatSalary(event) {
      const value = event.target.value.replace(/\D/g, "");
      const formatted = (Number(value) / 100).toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
        maximumFractionDigits: 2,
      });

      this.job.salary = formatted.replace("R$", "R$ ");
    },
  },
};
</script>
