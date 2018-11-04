Vue.component('update-profile-details', {
    props: ['user'],

    data() {
        return {
            form: new SparkForm({
                name: '',
                email: '',
                phone: ''
            })
        };
    },
    computed: {
        actualPhone: function() {
            if (this.form.phone != '') 
                return "61" + this.form.phone.replace(/\b0+/g, '')
            else 
                return ''
        }
    },
    mounted() {
        this.form.phone = this.user.phone.substring(2);
        this.form.name = this.user.name;
        this.form.email = this.user.email;
    },

    methods: {
        update() {
            var phone = this.form.phone;
            this.form.phone = this.actualPhone;
            Spark.put('api/settings/profile/details', this.form)
                .then(response => {
                    this.form.phone = phone.replace(/\b0+/g, '');
                    Bus.$emit('updateUser');
                });
        }
    }
});
