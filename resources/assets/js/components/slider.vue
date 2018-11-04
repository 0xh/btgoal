<template>
      <vue-slider ref="flickity" :options="flickityOptions"> </vue-slider> 
</template>
<script>
import Flickity from 'vue-flickity';
    export default {
      data () {
            return {
                flickityOptions: {
                    initialIndex: 3,
                    prevNextButtons: false,
                    pageDots: false,
                    wrapAround: true

                    // any options from Flickity can be used
                }
            }
        },

        methods: {
            next() {
                this.$refs.flickity.next();
            },

            previous() {
                this.$refs.flickity.previous();
            }
        }
    }
</script>
