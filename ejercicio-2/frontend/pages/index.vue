<template lang="pug">
v-container.justify-center(fill-height)

  v-data-table(:headers="headers" :items="items")
  v-snackbar(v-model="snackbar" :color="color")
    v-row.ps-2.align-center
      | {{ text }}
      v-spacer
      v-btn(icon @click="snackbar=false")
        v-icon mdi-close
</template>

<script>
export default {
  name: 'IndexPage',

  data () {
    return {
      items: [],
      snackbar: false,
      color: 'success',
      text: ''
    }
  },

  computed: {
    headers () {
      return [
        { text: 'Código', value: 'codigo' },
        { text: 'Archivo', value: 'nombrearchivo' },
        { text: 'Líneas', value: 'cantlineas' },
        { text: 'Palabras', value: 'cantpalabras' },
        { text: 'Caracteres', value: 'cantcaracteres' },
        { text: 'Fecha registro', value: 'fecharegistro' }
      ]
    }
  },

  beforeMount () {
    this.getData()
  },

  methods: {
    async getData () {
      try {
        this.items = (await this.$axios.$get('http://localhost:5000/')).items
        this.text = 'Datos obtenidos con éxito'
        this.color = 'success'
        this.snackbar = true
      } catch (err) {
        this.text = err
        this.color = 'error'
        this.snackbar = true
      }
    }
  }
}
</script>
