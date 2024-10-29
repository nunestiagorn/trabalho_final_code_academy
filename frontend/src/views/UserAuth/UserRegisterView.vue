<template>
  <main class="flex w-full">

    <section class="h-screen bg-secondaryColor w-full bg-register-cover flex items-center justify-center">
      <img src="../../assets/images/register.jpg" alt="Foto de entrevista na página de login"
        class="w-[36rem] h-[28rem] rounded-2xl shadow-shadow1 bg-contain bg-center" />
    </section>

    <section class="h-screen text-slate-950 flex flex-col gap-7 w-4/6 px-10 py-5">
      <div class="flex gap-4 items-center">
        <img src="../../assets/images/logo.png" alt="Logo da página" class="w-20 invert" />
        <h1 class="text-5xl font-bold italic">Pampa's RH</h1>
      </div>
      <div class="italic font-medium">
        <h3 class="text-2xl font-bold">Bem-vindo ao Pampa's RH Enterprises</h3>
        <h4 class="text-lg">
          Encontre aqui as melhores qualificações e oportunidades para a sua carreira!
        </h4>
      </div>

      <div class="flex items-center justify-center">
        <form action="" class="w-9/12 flex flex-col gap-8">
          <div class="flex items-center border-b-2 border-black">
            <UserPlus class="ml-2" />
            <input type="text" class="input1" placeholder="Insira seu nome" />
          </div>

          <div class="flex items-center border-b-2 border-black">
            <Mail class="ml-2" />
            <input type="email" class="input1" placeholder="Insira seu email" />
          </div>

          <div class="flex items-center border-b-2 border-black">
            <LockKeyhole class="ml-2" />
            <input type="password" class="input1" placeholder="Insira sua senha" />
          </div>

          <div class="flex justify-between items-center">
            <div class="flex flex-col gap-1">
              <p>Já possui uma conta?</p>
              <div class="flex gap-1 group">
                <RouterLink to="/login" class="underline underline-offset-4 hover:text-secondaryColor">
                  <p>Entre agora mesmo!</p>
                </RouterLink>
                <ArrowRight class="size-5 self-center group-hover:translate-x-2 transition-all duration-150" />
              </div>
              <div class="flex gap-1 group">
                <RouterLink to="/recruiter-login" class="underline underline-offset-4 hover:text-secondaryColor">
                  <p>É um recrutador? Entre aqui!</p>
                </RouterLink>
                <ArrowRight class="size-5 self-center group-hover:translate-x-2 transition-all duration-150" />
              </div>
            </div>
            <button class="px-5 py-2.5 hover:text-zinc-300 bg-lightBlue rounded-[100px]
          hover:bg-primaryColor transition-all items-center shadow-xl font-bold hover:rounded-xl">
              Criar
            </button>
          </div>
        </form>
      </div>

      <div class="flex font-bold text-lg absolute bottom-6 right-6">
        <RouterLink to="/" class="pl-3 pr-4 py-2.5 hover:text-zinc-300 bg-lightBlue rounded-[100px] hover:bg-primaryColor
          transition-all items-center duration-150 shadow-xl flex gap-0.5 hover:rounded-xl">
          <ArrowLeft />
          Home
        </RouterLink>
      </div>
    </section>
  </main>
</template>

<script>
import { ArrowLeft, ArrowRight, LockKeyhole, Mail, UserPlus } from 'lucide-vue-next'

export default {
  components: {
    ArrowLeft,
    ArrowRight,
    LockKeyhole,
    Mail,
    UserPlus
  },
  data() {
    return {
      users: {
        id: '',
        name: '',
        email: '',
        role: '',
        password: '',
        id_companies: '',
      }
    }
  }
}
</script>
