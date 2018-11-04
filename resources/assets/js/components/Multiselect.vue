<template>
    <div>
        <multi-select
            :show-labels="false"
            :options="options"
            :placeholder="placeholder"
            :searchable="true"
            :allow-empty="false"
            label = "name"
            track-by = "id"  
            v-model="value" 
            @select="updateValue"
        ></multi-select>
    </div>
</template>

<script>
    import  Multiselect from 'vue-multiselect'
    export default {
        props: ['options', 'code'],
        components: {
            'multi-select': Multiselect
        },
        computed: {
            value() {
                return this.code;
            }
        },
        methods: {
            updateValue(option) {
                this.$emit('input', option.id);
            }
        }
    }
</script>