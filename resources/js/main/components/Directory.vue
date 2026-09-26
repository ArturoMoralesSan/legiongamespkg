<template>
    <div data-aos="fade-up" class="directorio md:row">
      <div class="card__directory col md:col-1/4 mb-16" v-for="persona in personas" :key="persona.correo">
        <div
          class="card__directory__header"
        >
        <img
          v-if="persona.image_url"
          class="card__directory__avatar"
          :src="persona.image_url"
          alt="Foto de perfil"
        />
        <img
          v-else
          class="card__directory__avatar"
          src="/img/default.png"
          alt="Foto por defecto"
        />
        </div>
        <div class="card__directory__body">
          <h3 class="card__directory__nombre">{{ persona.name }}</h3>
          <p class="card__directory__puesto">{{ persona.position }}</p>
          <p class="card__directory__correo">
            <a :href="`mailto:${persona.email}`">{{ persona.email }}</a>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      directories: {
        type: Array,
        required: true
      }
    },
    computed: {
      personas() {
        return this.directories;
      }
    }
  }
  </script>

  