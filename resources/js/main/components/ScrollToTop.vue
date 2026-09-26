<template>
    <button
      class="scroll-to-top"
      v-show="showButton"
      @click="scrollToTop"
      aria-label="Subir al inicio"
    >
    <i class="fa-solid fa-chevron-up"></i>
    </button>
  </template>
  
  <script>
  export default {
    name: "ScrollToTop",
    data() {
      return {
        showButton: false,
        observer: null
      };
    },
    mounted() {
      const footer = document.querySelector("footer");
      if (footer) {
        this.observer = new IntersectionObserver(
          ([entry]) => {
            this.showButton = entry.isIntersecting;
          },
          {
            root: null,
            threshold: 0.1
          }
        );
        this.observer.observe(footer);
      }
    },
    beforeDestroy() {
      if (this.observer) {
        this.observer.disconnect();
      }
    },
    methods: {
      scrollToTop() {
        window.scrollTo({
          top: 0,
          behavior: "smooth"
        });
      }
    }
  };
  </script>
  
  <style scoped>
  .scroll-to-top {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 20px;
    right: 20px;
    background: #edc142;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    z-index: 999;
    transition: opacity 0.3s ease;
  }
  </style>
  