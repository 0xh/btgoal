import VueGoogleAutocomplete from 'vue-google-autocomplete';

Vue.component('about-me', {
    // props: ['user'],

    data() {
        return {
            mode_edit: {
                'home_edit': false,
                'work_edit': false,
                'favman_edit': false,
                'favfilm_edit': false,
            },
            home_addr: '',
            work_addr: '',
        };
    },
    components: {
        'vue-google-autocomplete': VueGoogleAutocomplete
    },
    methods: {
        toggleShow(name) {
            this.mode_edit[name] = !this.mode_edit[name];
        },
        getHomeAddressData: function (addressData, placeResultData, id) {
            this.home_addr = addressData;
            console.log('home address', this.home_addr);
        },
        getWorkAddressData: function (addressData, placeResultData, id) {
            this.work_addr = addressData;
            console.log('work address', this.work_addr);
        },
        saveMyData: function() {
            console.log('abcde');
            Spark.put('/api/update/about-me', { home: this.home_addr })
            .then((data) => {
                console.log('response from update about me', data);
            });
        }
    }
});
