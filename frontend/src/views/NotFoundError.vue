<template>
  <div
    class="bg-darkBlue h-screen flex flex-col items-center justify-center text-zinc-300"
  >
    <div
      class="shadow-inset1 p-12 flex flex-col items-center gap-8 rounded-2xl"
    >
      <h1 class="font-semibold text-5xl underline underline-offset-8">
        ERROR 404
      </h1>
      <h1 class="font-medium text-4xl">
        Ops! Esta página não existe em nosso site!
      </h1>
      <RouterLink
        to="/"
        class="rounded-blob1 hover:rounded-blob2 transition-all bg-darkerBlue p-20 shadow-neumorfismo1 max-w-fit"
      >
        <h2 class="font-bold text-3xl">Voltar</h2>
      </RouterLink>
    </div>
  </div>
</template>
