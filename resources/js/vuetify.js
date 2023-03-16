
import Vue from 'vue'
import Vuetify from 'vuetify'

Vue.use(Vuetify)

const opts = {}

export default new Vuetify({
    theme: {
      themes: {
        light: {
          blue   :"#2e3289",
          primary: '#2e3289',
          secondary: '#b0bec5',
          accent: '#8c9eff',
          error: '#b71c1c',
        },
      },
    },
  })
