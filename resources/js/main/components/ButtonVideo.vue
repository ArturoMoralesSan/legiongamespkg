<template>
  <section id="plataforma">
    <div class="section__xl section-wrapper" :style="{ backgroundImage: 'url(' + backgroundImage + ')' }">
      <div class="overlay-section"></div>

      <div class="video-content">
        <h2 data-aos="fade-down" class="title h3 title__white text-center">{{ title }}</h2>
        <hr data-aos="fade-down" class="title__divisor">

        <p data-aos="fade-down" class="video-subtitle">{{ subtitle }}</p>
        <p data-aos="fade-down" class="video-description">{{ description }}</p>

        <div data-aos="fade-up" class="video-thumbnail" @click="openModal">
          <img :src="thumbnail" alt="Miniatura" />
          <div class="play-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de video -->
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content">
        <video ref="videoPlayer" controls autoplay class="video-player">
          <source :src="videoSrc" type="video/mp4" />
          Tu navegador no soporta la etiqueta de video.
        </video>
        <button @click="closeModal" class="close-btn">✖</button>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  props: {
    videoSrc: { type: String, required: true },
    thumbnail: { type: String, default: '/images/thumb.jpg' },
    backgroundImage: { type: String, default: '/images/fondo.jpg' },
    title: { type: String, default: 'Plataforma Networking' },
    subtitle: { type: String, default: 'Conecta, colabora y crece' },
    description: { type: String, default: 'Explora nuestra plataforma en este video.' }
  },
  data() {
    return {
      showModal: false
    };
  },
  methods: {
    openModal() {
      this.showModal = true;
      document.body.classList.add('no-scroll');
      this.$nextTick(() => {
        this.$refs.videoPlayer.play();
      });
    },
    closeModal() {
      this.$refs.videoPlayer.pause();
      this.showModal = false;
      document.body.classList.remove('no-scroll');
    }
  }
};
</script>
