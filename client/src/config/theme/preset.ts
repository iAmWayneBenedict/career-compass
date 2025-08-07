import { definePreset } from '@primeuix/themes'
import Aura from '@primeuix/themes/aura'

const ThemePreset = definePreset(Aura, {
  semantic: {
    primary: {
      '50': '#f0f9f3',
      '100': '#daf1e0',
      '200': '#b7e3c5',
      '300': '#88cda3',
      '400': '#56b17c',
      '500': '#3baa6d',
      '600': '#24774b',
      '700': '#1d5f3e',
      '800': '#194c33',
      '900': '#153f2b',
      '950': '#0b2318',
    },
  },
})

export default ThemePreset
export type MyPreset = typeof ThemePreset
