<template>
  <div class="max-w-[22rem] sm:max-w-[25rem] h-fit flex flex-col items-center">
    <slot name="header" />

    <div class="flex flex-col justify-center w-full rounded-2xl">
      <slot />
    </div>

    <slot name="footer" />
  </div>
</template>
