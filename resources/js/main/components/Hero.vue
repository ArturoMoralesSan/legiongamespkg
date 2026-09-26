<template>
    <div class="hero-container " :style="{ height: heroHeight }">
        <div 
          class="parallax-background" 
          :style="{
            backgroundImage: `url(${backgroundImage})`,
            backgroundPositionY: isParallaxActive ? `${scrollPosition * 0.3}px` : 'center'
          }"
        ></div>
        <div class="hero__overlay"></div>
        <div class="container">
            <slot name="container"></slot>
            
        </div>
    </div>
</template>

<script>
export default {
  props: {
    backgroundImage: {
      type: String,
      required: true, 
    },
    isParallaxActive: {
      type: Boolean,
      default: true,
    },
    heroHeight: {
      type: String,
      default: '90vh'
    },
  },
  data() {
    return {
      scrollPosition: 0,
    };
  },
  methods: {
    handleScroll() {
      if (this.isParallaxActive) {
        this.scrollPosition = window.scrollY;
      }
    },
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  },
};
</script>
