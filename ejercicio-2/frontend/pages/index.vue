<template lang="pug">
v-container.justify-center(fill-height)
  v-data-table(:headers="headers" :items="items")
    template(#top)
      v-toolbar(flat)
        v-toolbar-title Ejercicio 2
        v-spacer
        v-dialog(v-model="dialog" max-width="500px")
          template(#activator="{ on, attrs }")
            v-btn.primary(v-bind="attrs" v-on="on") Agregar archivo
          v-card
            v-card-title
              | Agregar archivo
              v-spacer
              v-btn(icon @click="dialog=false")
                v-icon mdi-close
            v-card-text
              v-form(ref="form" @submit.prevent="saveFile")
                v-row
                  v-col(cols="12")
                    v-file-input(v-model="file" label="Archivo"
                    :rules="[v => !!v || 'Archivo requerido']")
                v-card-actions
                  v-spacer
                  v-btn.primary(type="submit") Guardar

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
      dialog: false,
      items: [],
      snackbar: false,
      color: 'success',
      text: '',
      file: null
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

  watch: {
    dialog (value) {
      if (!value) {
        this.$refs.form.reset()
        this.$refs.form.resetValidation()
      }
    }
  },

  beforeMount () {
    this.getData()
  },

  methods: {
    showSnackbar (text, color, snackbar) {
      this.text = text
      this.color = color
      this.snackbar = snackbar
    },
    async getData () {
      try {
        this.items = (await this.$axios.$get('http://localhost:5000/')).items
        this.text = 'Datos obtenidos con éxito'
        this.color = 'success'
        this.snackbar = true
      } catch (err) {
        this.showSnackbar(err, 'error', true)
      }
    },
    async saveFile () {
      try {
        const data = new FormData()
        data.append('file', this.file)
        if (!this.$refs.form.validate()) { return }
        const message = await this.$axios.$post('http://localhost:5000/', data)
        this.getData()
        this.dialog = false
        this.showSnackbar(message, 'error', true)
      } catch (err) {
        this.showSnackbar(err, 'error', true)
      }
    }
  }
}
</script>
