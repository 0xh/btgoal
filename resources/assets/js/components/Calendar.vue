<template>
    <div class="hello">
      <full-calendar :eventSources="eventSources"> </full-calendar>
    </div>
</template>

<script>
    export default {
    data() {
        return {
            eventSources: [
              {
                events(start, end, timezone, callback) {
                  // console.log("ASIM "+ start + " HELLO" + end+self);
                },
                color: 'yellow',
                textColor: 'black',
              },
            ]
        };
    },
    // mounted() {
    //     console.log('Component mounted.')
    // }
    }
</script>
