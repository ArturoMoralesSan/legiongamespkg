<template>
  <div class="carousel">
    <div
      class="carousel-track"
      :style="!isMobile ? { transform: `translateX(-${currentIndex * (100 / visibleCount)}%)` } : {}"
    >
      <div
        class="carousel-item"
        v-for="(image, index) in images"
        :key="index"
      >
        <div class="brand__card">
          <img class="brand brand-gray" :src="image" alt="Proveedor" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    images: {
      type: Array,
      required: true,
    },
    visibleCount: {
      type: Number,
      default: 4,
    },
    intervalTime: {
      type: Number,
      default: 3000,
    },
  },
  data() {
    return {
      currentIndex: 0,
      interval: null,
      isMobile: false,
    };
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener("resize", this.checkScreenSize);
    this.startCarousel();
  },
  beforeDestroy() {
    clearInterval(this.interval);
    window.removeEventListener("resize", this.checkScreenSize);
  },
  methods: {
    startCarousel() {
      clearInterval(this.interval);
      if (this.isMobile) return;

      const maxIndex = this.images.length - this.visibleCount;
      if (maxIndex <= 0) return;

      this.interval = setInterval(() => {
        this.currentIndex =
          (this.currentIndex + 1) % (maxIndex + 1);
      }, this.intervalTime);
    },
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 768;
      this.currentIndex = 0;
      this.startCarousel();
    },
  },
};
</script>
